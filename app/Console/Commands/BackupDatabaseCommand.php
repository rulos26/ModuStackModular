<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\DbDumper\Databases\MySql;
use Spatie\DbDumper\Databases\PostgreSql;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BackupDatabaseCommand extends Command
{
    protected $signature = 'backup:database';
    protected $description = 'Crea un respaldo de la base de datos MySQL y lo sincroniza con PostgreSQL';

    public function handle()
    {
        $this->info('Iniciando proceso de respaldo de base de datos...');

        try {
            // 1. Crear respaldo de MySQL
            $this->info('Creando respaldo de MySQL...');
            $mysqlBackup = $this->createMysqlBackup();

            // 2. Restaurar en PostgreSQL
            $this->info('Sincronizando con PostgreSQL...');
            $this->syncToPostgresql($mysqlBackup);

            $this->info('Proceso de respaldo completado exitosamente.');

        } catch (\Exception $e) {
            $this->error('Error durante el proceso de respaldo: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    private function createMysqlBackup()
    {
        $filename = 'mysql_backup_' . now()->format('Y_m_d_H_i_s') . '.sql';
        $filepath = storage_path('app/backups/' . $filename);

        // Crear directorio si no existe
        if (!file_exists(dirname($filepath))) {
            mkdir(dirname($filepath), 0755, true);
        }

        MySql::create()
            ->setDbName(config('database.connections.mysql.database'))
            ->setUserName(config('database.connections.mysql.username'))
            ->setPassword(config('database.connections.mysql.password'))
            ->setHost(config('database.connections.mysql.host'))
            ->setPort(config('database.connections.mysql.port'))
            ->dumpToFile($filepath);

        $this->info("Respaldo de MySQL creado: {$filename}");
        return $filepath;
    }

    private function syncToPostgresql($mysqlBackupFile)
    {
        try {
            // Leer el archivo SQL de MySQL
            $sqlContent = file_get_contents($mysqlBackupFile);

            // Convertir sintaxis MySQL a PostgreSQL
            $postgresqlContent = $this->convertMysqlToPostgresql($sqlContent);

            // Guardar archivo convertido
            $postgresqlFile = str_replace('.sql', '_postgresql.sql', $mysqlBackupFile);
            file_put_contents($postgresqlFile, $postgresqlContent);

            // Limpiar tablas existentes en PostgreSQL (opcional)
            $this->cleanPostgresqlTables();

            // Ejecutar el script en PostgreSQL
            $this->executePostgresqlScript($postgresqlFile);

            $this->info('Sincronización con PostgreSQL completada.');

        } catch (\Exception $e) {
            $this->error('Error al sincronizar con PostgreSQL: ' . $e->getMessage());
            throw $e;
        }
    }

    private function convertMysqlToPostgresql($sqlContent)
    {
        // Conversiones básicas de MySQL a PostgreSQL
        $conversions = [
            // Tipos de datos
            '/`([^`]+)`/u' => '"$1"', // Backticks a comillas dobles
            '/AUTO_INCREMENT/' => 'SERIAL',
            '/ENGINE=InnoDB/' => '',
            '/DEFAULT CHARSET=utf8mb4/' => '',
            '/COLLATE utf8mb4_unicode_ci/' => '',
            '/UNSIGNED/' => '',
            '/TINYINT\(1\)/' => 'BOOLEAN',
            '/DATETIME/' => 'TIMESTAMP',
            '/LONGTEXT/' => 'TEXT',
            '/MEDIUMTEXT/' => 'TEXT',

            // Funciones
            '/NOW\(\)/' => 'CURRENT_TIMESTAMP',
            '/CURDATE\(\)/' => 'CURRENT_DATE',
            '/CURTIME\(\)/' => 'CURRENT_TIME',
        ];

        foreach ($conversions as $pattern => $replacement) {
            $sqlContent = preg_replace($pattern, $replacement, $sqlContent);
        }

        return $sqlContent;
    }

    private function cleanPostgresqlTables()
    {
        $tables = ['ventas', 'productos', 'users'];

        foreach ($tables as $table) {
            try {
                DB::connection('pgsql')->statement("DROP TABLE IF EXISTS {$table} CASCADE");
            } catch (\Exception $e) {
                // Ignorar errores si la tabla no existe
            }
        }
    }

    private function executePostgresqlScript($scriptFile)
    {
        $host = config('database.connections.pgsql.host');
        $port = config('database.connections.pgsql.port');
        $database = config('database.connections.pgsql.database');
        $username = config('database.connections.pgsql.username');
        $password = config('database.connections.pgsql.password');

        $command = "PGPASSWORD={$password} psql -h {$host} -p {$port} -U {$username} -d {$database} -f {$scriptFile}";

        $output = [];
        $returnCode = 0;

        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            throw new \Exception('Error ejecutando script PostgreSQL: ' . implode("\n", $output));
        }
    }
}

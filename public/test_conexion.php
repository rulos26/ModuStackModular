<?php

/**
 * Script de Prueba de Conexión a Base de Datos MySQL
 *
 * Coloca este archivo en la carpeta `public` de tu proyecto Laravel
 * y accede a él desde el navegador para probar la conexión al servidor remoto.
 * Ejemplo: http://tu-dominio.test/test_conexion.php
 */

header('Content-Type: text/plain; charset=utf-8');

// --- Variables de Conexión ---
// Estas son las variables que proporcionaste para tu servidor remoto.
$db_host     = '82.197.82.130';
$db_port     = '3306';
$db_database = 'u494150416_VXxaN';
$db_username = 'u494150416_Bqi7f';
$db_password = '6*K&7}g#C9Yld/CF';

echo "Intentando conectar a la base de datos...\n";
echo "Host: {$db_host}\n";
echo "Base de datos: {$db_database}\n\n";

// Desactivar la notificación de errores para no mostrar warnings si la conexión falla,
// ya que lo manejaremos nosotros mismos.
mysqli_report(MYSQLI_REPORT_OFF);

// --- Intento de Conexión ---
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_database, (int)$db_port);

// --- Verificación de la Conexión ---
if ($mysqli->connect_error) {
    echo "-----------------------------------\n";
    echo "¡ERROR DE CONEXIÓN!\n";
    echo "-----------------------------------\n";
    echo "Error: " . $mysqli->connect_error . "\n";
    echo "Código de error: " . $mysqli->connect_errno . "\n";
} else {
    echo "-----------------------------------\n";
    echo "¡CONEXIÓN EXITOSA!\n";
    echo "-----------------------------------\n";
    echo "La conexión con la base de datos '{$db_database}' en '{$db_host}' se ha establecido correctamente.\n";
    // Cierra la conexión
    $mysqli->close();
}

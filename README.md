# Sistema de Administración de Inventario Modular

Un sistema completo de gestión de inventario desarrollado con Laravel 11, arquitectura modular y tecnologías modernas.

## 🚀 Características Principales

### 📦 Módulo de Productos
- Gestión completa de productos con SKU único
- Tabla interactiva con búsqueda en tiempo real
- Ordenación por nombre, SKU o stock
- Control de stock automático
- Interfaz moderna con Tailwind CSS

### 🛒 Módulo de Ventas
- Registro de ventas con validación de stock
- Decremento automático de inventario
- Historial completo de transacciones
- Formulario dinámico con Livewire
- Cálculo automático de totales

### 📊 Módulo de Reportes
- Dashboard interactivo con estadísticas en tiempo real
- Gráficos de ventas por mes con Chart.js
- Análisis de productos con stock bajo
- Insights automáticos inteligentes
- Métricas de rendimiento

### 🤖 Módulo de Inteligencia Artificial
- **Chatbot Inteligente**: Responde preguntas sobre inventario en lenguaje natural
- **Predicciones de Stock**: Análisis predictivo basado en ventas históricas
- **Insights Automáticos**: Recomendaciones inteligentes para optimizar inventario

### 🔧 Módulo de Mantenimiento
- Respaldo automático diario de base de datos
- Sincronización MySQL → PostgreSQL
- Comando programado para respaldos
- Gestión de archivos de respaldo

### 👥 Módulo de Usuarios
- Autenticación con Laravel Sanctum
- Sistema de registro y login
- Gestión de sesiones seguras

## 🛠️ Tecnologías Utilizadas

- **Laravel 11.37.0** - Framework PHP
- **Livewire 3.0** - Interfaces dinámicas
- **Tailwind CSS** - Framework CSS
- **Chart.js** - Gráficos interactivos
- **Font Awesome** - Iconografía
- **MySQL** - Base de datos principal
- **PostgreSQL** - Base de datos secundaria
- **Spatie Laravel Backup** - Gestión de respaldos

## 📋 Requisitos del Sistema

- PHP 8.2 o superior
- Composer
- MySQL 5.7 o superior
- PostgreSQL 12 o superior
- Node.js y NPM (para assets)

## 🚀 Instalación

### 1. Clonar el Repositorio
```bash
git clone <repository-url>
cd ModuStackModular
```

### 2. Instalar Dependencias
```bash
composer install
npm install
```

### 3. Configurar Variables de Entorno
```bash
cp .env.example .env
php artisan key:generate
```

Configurar las siguientes variables en `.env`:
```env
# Base de datos MySQL (principal)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventario_modular
DB_USERNAME=root
DB_PASSWORD=

# Base de datos PostgreSQL (secundaria)
PG_HOST=127.0.0.1
PG_PORT=5432
PG_DATABASE=inventario_modular_pg
PG_USERNAME=postgres
PG_PASSWORD=
```

### 4. Ejecutar Migraciones
```bash
php artisan migrate
```

### 5. Compilar Assets
```bash
npm run build
```

### 6. Iniciar el Servidor
```bash
php artisan serve
```

## 📁 Estructura de Módulos

```
Modules/
├── Usuarios/          # Autenticación y gestión de usuarios
├── Productos/         # Gestión de inventario
├── Ventas/           # Procesamiento de ventas
├── Reportes/         # Dashboard y análisis
├── Mantenimiento/    # Respaldos y mantenimiento
└── IA/              # Inteligencia artificial
```

## 🎯 Funcionalidades por Módulo

### Módulo de Productos
- ✅ CRUD completo de productos
- ✅ Búsqueda en tiempo real
- ✅ Ordenación dinámica
- ✅ Validación de SKU único
- ✅ Control de stock

### Módulo de Ventas
- ✅ Registro de ventas
- ✅ Validación de stock disponible
- ✅ Decremento automático de inventario
- ✅ Historial de transacciones
- ✅ Cálculo de totales

### Módulo de Reportes
- ✅ Dashboard con métricas clave
- ✅ Gráfico de ventas por mes
- ✅ Productos con stock bajo
- ✅ Ventas recientes
- ✅ Insights automáticos

### Módulo de IA
- ✅ Chatbot conversacional
- ✅ Predicciones de stock
- ✅ Análisis de tendencias
- ✅ Recomendaciones inteligentes

### Módulo de Mantenimiento
- ✅ Respaldo automático diario
- ✅ Sincronización de bases de datos
- ✅ Comando programado
- ✅ Gestión de archivos

## 🔧 Comandos Disponibles

### Respaldo de Base de Datos
```bash
php artisan backup:database
```

### Programar Tareas
```bash
php artisan schedule:work
```

## 🌐 Rutas Principales

- `/` - Dashboard principal (redirige a reportes)
- `/productos` - Gestión de productos
- `/ventas` - Gestión de ventas
- `/reportes` - Dashboard de reportes
- `/ia` - Inteligencia artificial

## 🤖 Uso del Chatbot

El chatbot puede responder preguntas como:
- "¿Cuál es el producto más vendido?"
- "¿Qué productos tienen stock bajo?"
- "¿Cuántas ventas hubo hoy?"
- "¿Cuáles son los ingresos totales?"
- "¿Cuántos productos hay en total?"

## 📊 Predicciones de Stock

El sistema analiza las ventas de los últimos 30 días para:
- Calcular el stock recomendado
- Predecir días hasta agotarse
- Identificar productos que necesitan reposición
- Generar alertas automáticas

## 🔒 Seguridad

- Autenticación con Laravel Sanctum
- Validación de datos en todos los formularios
- Protección CSRF
- Sanitización de inputs
- Respaldos automáticos

## 📈 Monitoreo

- Logs de actividades
- Métricas de rendimiento
- Alertas de stock bajo
- Reportes automáticos

## 🚀 Despliegue

### Producción
1. Configurar variables de entorno de producción
2. Ejecutar `composer install --optimize-autoloader --no-dev`
3. Ejecutar `php artisan config:cache`
4. Ejecutar `php artisan route:cache`
5. Ejecutar `php artisan view:cache`
6. Configurar cron job para `php artisan schedule:run`

### Docker (Opcional)
```bash
docker-compose up -d
```

## 🤝 Contribución

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 📞 Soporte

Para soporte técnico o preguntas:
- Crear un issue en GitHub
- Contactar al equipo de desarrollo

## 🎉 ¡Sistema Listo!

El sistema de inventario modular está completamente funcional y listo para usar. Todas las funcionalidades han sido implementadas según las especificaciones requeridas.

### Características Implementadas:
✅ Arquitectura modular con Laravel Modules  
✅ Interfaz moderna con Tailwind CSS  
✅ Componentes dinámicos con Livewire  
✅ Gráficos interactivos con Chart.js  
✅ Inteligencia artificial con chatbot  
✅ Predicciones de stock automáticas  
✅ Sistema de respaldos programado  
✅ Autenticación con Sanctum  
✅ Gestión completa de inventario  
✅ Reportes y análisis en tiempo real  

¡Disfruta de tu nuevo sistema de inventario inteligente! 🚀

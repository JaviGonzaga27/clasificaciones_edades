# Sistema de Clasificación por Edad

Este proyecto es un sistema de clasificación por edad desarrollado en Laravel que redirige a los usuarios a diferentes secciones del sitio según su edad.

## Características

- Validación de edad mediante un formulario
- Clasificación automática en 7 categorías de edad
- Protección de rutas según la edad del usuario
- Registro de accesos con información de edad e IP
- Interfaz responsiva con Bootstrap

## Rangos de edad y clasificaciones

| Edad        | Clasificación      | Ruta           |
|-------------|-------------------|----------------|
| 0-5         | Bebés             | /bebes         |
| 6-12        | Niños             | /ninos         |
| 13-17       | Adolescentes      | /adolescentes  |
| 18-25       | Jóvenes adultos   | /jovenes       |
| 26-59       | Adultos           | /adultos       |
| 60-74       | Adultos mayores   | /mayores       |
| 75-120      | Personas longevas | /longevos      |

## Requisitos previos

- PHP >= 8.1
- Composer
- PostgreSQL o cualquier base de datos compatible con Laravel
- Node.js y NPM (para compilar assets)

## Instalación

1. Clonar el repositorio:

        git clone https://github.com/javiigonzaga/clasificacion-edad.git
        cd clasificacion-edad
        
        Instalar dependencias PHP:
        composer install
        
        Copiar el archivo de entorno:
        cp .env.example .env
        
        Generar la clave de aplicación:
        php artisan key:generate
        
        Configurar la base de datos en el archivo .env:
        DB_CONNECTION=pgsql
        DB_HOST=127.0.0.1
        DB_PORT=5432
        DB_DATABASE=clasificacion_edad
        DB_USERNAME=admin
        DB_PASSWORD=

2. Ejecutar las migraciones:
        
        php artisan migrate
        (Opcional) Instalar dependencias JavaScript y compilar assets:

        npm install
        npm run dev

        Iniciar el servidor de desarrollo:

        php artisan serve

        Acceder a la aplicación en tu navegador:

        http://localhost:8000

        Ingresa tu edad en el formulario inicial para ser dirigido a la sección correspondiente.

## Estructura del proyecto

    App/Http/Middleware/AgeValidator.php: Middleware que gestiona la validación de  edad y protección de rutas.

    App/Services/AgeRouterService.php: Servicio que determina la clasificación y    rutas según la edad.

    App/Http/Controllers/: Controladores para cada categoría de edad.

    App/Models/AgeLog.php: Modelo para el registro de accesos.

    resources/views/: Vistas de la aplicación.

    Personalización
    Modificar rangos de edad
    Si necesitas modificar los rangos de edad, debes hacer cambios en:

    App/Services/AgeRouterService.php - Propiedad $ageRanges y método   getClassificationByAge().
    Los controladores correspondientes a cada categoría para actualizar la  información presentada al usuario.

    Añadir nuevas categorías
    Para añadir una nueva categoría de edad:

    Crea un nuevo controlador.
    Añade la nueva ruta en routes/web.php.
    Crea la vista correspondiente.
    Actualiza AgeRouterService.php con la nueva categoría.

## Características adicionales

    El sistema registra cada acceso, almacenando la edad del usuario y su dirección     IP.
    El usuario puede cambiar su edad en cualquier momento haciendo clic en "Cambiar     Edad".
    Redirección automática a la sección adecuada si intenta acceder a una sección   que no corresponde a su edad.

## Solución de problemas
    Error "No application encryption key has been specified"
    Este error ocurre cuando la clave de aplicación no está configurada. Ejecuta:
    bashphp artisan key:generate
    Errores de caché
    Si experimentas comportamientos inesperados, intenta limpiar la caché:
    bashphp artisan config:clear
    php artisan cache:clear
    php artisan view:clear

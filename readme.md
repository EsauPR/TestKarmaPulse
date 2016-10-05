# Test - KarmaPulse

## Requerimientos

- Composer
- PHP >= 5.5.9
- MongoDB > 3.2.x
- MongoDB PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension

## Configuración

Descarga el zip o clona el repositorio

    $ git clone https://github.com/EsauPR/TestKarmaPulse.git

Entra al directorio e instala las dependecias de Composer

    $ cd TestKarmaPulse && composer install

Copia el archivo de configuración *.env.example* y renombralo a *.env* y genera la clave de la aplicación

    $  cp .env.example .env
    $ php artisan key:generate

Configura la base de datos en el archivo .env usando el driver para MongoDB

    DB_CONNECTION=mongodb
    DB_HOST=127.0.0.1
    DB_PORT=27017
    DB_DATABASE=KMetrics
    DB_USERNAME=username
    DB_PASSWORD=secret

**Si no tienes asignado un usuario y contraseña para MongoDB** omite las parámetros *DB_USERNAME* y *DB_PASSWORD*, de lo contrario, asigna tus credenciales y descomenta las claves **username** y **password** en el array de conexiones del configuración de la base de datos *config/database.php*

    'mongodb' => [
        'driver'   => 'mongodb',
        'host'     => env('DB_HOST', 'localhost'),
        'port'     => env('DB_PORT', 27017),
        'database' => env('DB_DATABASE'),
        //'username' => env('DB_USERNAME'),
        //'password' => env('DB_PASSWORD'),
        'use_mongo_id' => false,
        'options' => [
            'db' => 'admin', // Sets the authentication database required by mongo 3
            //['replicaSet' => 'replicaSetName'], // Connect to multiple servers or replica sets
        ]
    ],

Importa la base de datos a MongoDB localizada en el directorio *_DB*

    $ mongorestore --db KMetrics _DB/KMetrics

Puedes ejecutar la aplicación rápidamente usando el servidor embebido de PHP desplegándose en http://localhost:8000/

    $ php artisan serve

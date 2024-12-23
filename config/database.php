<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'tables' => [
        'STATE_TABLE' => 'STATE',
        'DISTRICT_TABLE' => 'DISTRICT',
        'BLOCK_TABLE' => 'BLOCK',
        'VILLAGE_TABLE' => 'VILLAGE',
        'CODE_TABLE' => 'CODES',
        'REGISTRATION_TABLE' => 'REGISTRATION',
        'SURVEY_TABLE' => 'SURVEY',
        'DOCUMENT_TABLE' => 'DOCUMENT',
        'PAYMENT_TABLE' => 'PAYMENT',
        'CONVERSION_TABLE' => 'CONV_FACT',
        'USER_TABLE' => 'USER',
        'CONTACT_TABLE' => 'CONTACT',
        'LEASE_TABLE' => 'LEASE',
        'CITY_TABLE' => 'CITY',
        'PLOTGEOMETRY_TABLE' => 'PLOT_GEOMETRY',
        'SUBCLASSIFICATION_TABLE' => 'SUB_CLASSIFICATION',
        'USER_LOGIN_TABLE' => 'USER_LOGIN',
        'PATTA_TABLE' => 'PATTA',
        'FORM_TABLE' => 'FORM',
        'MUTATION_TABLE' => 'MUTATION',
        'MUTATION_SURVEY_TABLE' => 'MUTATION_SURVEY',
        'INSPECTION_TABLE' => 'INSPECTION',
        'RESERVATION_TABLE' => 'LAND_RESERVATION',
        'RESERVATION_SURVEY_TABLE' => 'LAND_RESERVATION_SURVEY',
        'MULTIPLE_DOCS_TABLE' => 'MULTIPLE_DOCS',
        'OPERATION_TABLE' => 'OPERATION',
        'DISPUTES_TABLE' => 'DISPUTES',
        'DISPUTES_SURVEY_TABLE' => 'DISPUTES_SURVEY',
        'MINING_LEASE_TABLE' => 'MINING_LEASE',
        'MINING_LEASE_SURVEY_TABLE' => 'MINING_LEASE_SURVEY',
        'CEILING_TABLE' => 'LAND_CEILING',
        'CEILING_SURVEY_TABLE' => 'LAND_CEILING_SURVEY',
        'LAND_CONVERSION_TABLE' => 'LAND_CONVERSION',
        'LAND_CONVERSION_SURVEY_TABLE' => 'LAND_CONVERSION_SURVEY',
        'LAND_EXCHANGE_TABLE' => 'LAND_EXCHANGE',
        'LAND_EXCHANGE_SURVEY_TABLE' => 'LAND_EXCHANGE_SURVEY',
        'AUDIT_MASTER_TABLE' => 'AUDIT_MASTER',
        'AUDIT_STATUS_REG_TABLE' => 'AUDIT_STATUS_REG',
        'AUDIT_STATUS_DATA_TABLE' => 'AUDIT_STATUS_DATA',
        'ASSIGNED_STATE_DISTRICT_TABLE' => 'ASSGINED_STATE_DISTRICTS',
        'DATA_LOG_TABLE' => 'DATA_LOG',
        'FORGOT_PWD_LINK_TABLE' => 'FORGOT_PWD_LINKS',
        'PARENT_CONVERSION_TABLE' => 'PARENT_CONVERSION',
        'CONVERTED_REGISTRATION_TABLE' => 'CONVERTED_REGISTRATIONS',
        'HYPOTHECATION_TABLE' => 'HYPOTHECATION',
        'HYPOTHECATION_REGISTRATION_TABLE' => 'HYPOTHECATION_REGISTRATION',
        'FAMILY_TABLE' => 'FAMILY',
        'APPROVAL_TABLE' => 'APPROVAL',
		'APPROVAL_PROCESS_TRACK_TABLE' => 'APPROVAL_PROCESS_TRACK',
		'SURVEY_MAP' => 'SURVEY_MAP',
		'SHP_HISTORY_TABLE' => 'SHP_HISTORY'
    ],

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];

<?php

return [

    /*
      |--------------------------------------------------------------------------
      | PDO Fetch Style
      |--------------------------------------------------------------------------
      |
      | By default, database results will be returned as instances of the PHP
      | stdClass object; however, you may desire to retrieve records in an
      | array format for simplicity. Here you can tweak the fetch style.
      |
     */

    'fetch' => PDO::FETCH_CLASS,
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
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'DALMIA_LAMS'),
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', 'admin@123'),
            'charset' => 'utf8',
            'prefix' => env('DB_PREFIX', 'T_'),
            'schema' => 'public',
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
      | provides a richer set of commands than a typical key-value systems
      | such as APC or Memcached. Laravel makes it easy to dig right in.
      |
     */
    'redis' => [

        'cluster' => false,
        'default' => [
            'host' => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],
    ],
];

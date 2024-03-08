<?php return array (
  'adldap' => 
  array (
    'connections' => 
    array (
      'default' => 
      array (
        'auto_connect' => true,
        'connection' => 'Adldap\\Connections\\Ldap',
        'schema' => 'Adldap\\Schemas\\ActiveDirectory',
        'connection_settings' => 
        array (
          'account_prefix' => '',
          'account_suffix' => '@acme.org',
          'domain_controllers' => 
          array (
            0 => 'corp-dc1.corp.acme.org',
            1 => 'corp-dc2.corp.acme.org',
          ),
          'port' => 389,
          'timeout' => 5,
          'base_dn' => 'dc=corp,dc=acme,dc=org',
          'admin_account_suffix' => '@acme.org',
          'admin_username' => 'username',
          'admin_password' => 'password',
          'follow_referrals' => false,
          'use_ssl' => false,
          'use_tls' => false,
        ),
      ),
    ),
  ),
  'app' => 
  array (
    'env' => 'local',
    'debug' => true,
    'url' => '',
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'key' => 'S043rl4v4ABY6PvkTejMejtsLIRipr2d',
    'cipher' => 'AES-256-CBC',
    'log' => 'single',
    'log_level' => 'debug',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      13 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      14 => 'Illuminate\\Queue\\QueueServiceProvider',
      15 => 'Illuminate\\Redis\\RedisServiceProvider',
      16 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      17 => 'Illuminate\\Session\\SessionServiceProvider',
      18 => 'Illuminate\\Translation\\TranslationServiceProvider',
      19 => 'Illuminate\\Validation\\ValidationServiceProvider',
      20 => 'Illuminate\\View\\ViewServiceProvider',
      21 => 'App\\Providers\\AppServiceProvider',
      22 => 'App\\Providers\\AuthServiceProvider',
      23 => 'App\\Providers\\EventServiceProvider',
      24 => 'App\\Providers\\RouteServiceProvider',
      25 => 'Collective\\Html\\HtmlServiceProvider',
      26 => 'Proengsoft\\JsValidation\\JsValidationServiceProvider',
      27 => 'Lavary\\Menu\\ServiceProvider',
      28 => 'Adldap\\Laravel\\AdldapServiceProvider',
      29 => 'Zizaco\\Entrust\\EntrustServiceProvider',
      30 => 'Maatwebsite\\Excel\\ExcelServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Form' => 'Collective\\Html\\FormFacade',
      'HTML' => 'Collective\\Html\\HtmlFacade',
      'JsValidator' => 'Proengsoft\\JsValidation\\Facades\\JsValidatorFacade',
      'Menu' => 'Lavary\\Menu\\Facade',
      'Adldap' => 'Adldap\\Laravel\\Facades\\Adldap',
      'Entrust' => 'Zizaco\\Entrust\\EntrustFacade',
      'Excel' => 'Maatwebsite\\Excel\\Facades\\Excel',
    ),
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\Models\\User\\UserModel',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'email' => 'auth.emails.password',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
  ),
  'broadcasting' => 
  array (
    'default' => 'pusher',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => NULL,
        'secret' => NULL,
        'app_id' => NULL,
        'options' => 
        array (
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'D:\\wamp\\www\\dalmia-lams\\storage\\framework/cache',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
    ),
    'prefix' => 'laravel',
  ),
  'compile' => 
  array (
    'files' => 
    array (
    ),
    'providers' => 
    array (
    ),
  ),
  'database' => 
  array (
    'fetch' => 8,
    'default' => 'pgsql',
    'tables' => 
    array (
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
      'SHP_HISTORY_TABLE' => 'SHP_HISTORY',
    ),
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'database' => 'DALMIA_LAMS',
        'prefix' => '',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '5432',
        'database' => 'DALMIA_LAMS',
        'username' => 'postgres',
        'password' => 'admin@123',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
        'strict' => false,
        'engine' => NULL,
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'host' => '127.0.0.1',
        'port' => '5432',
        'database' => 'DALMIA_LAMS',
        'username' => 'postgres',
        'password' => 'admin@123',
        'charset' => 'utf8',
        'prefix' => 'T_',
        'schema' => 'public',
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'cluster' => false,
      'default' => 
      array (
        'host' => 'localhost',
        'password' => NULL,
        'port' => 6379,
        'database' => 0,
      ),
    ),
  ),
  'entrust' => 
  array (
    'role' => 'App\\Models\\Role\\Role',
    'roles_table' => 'T_ROLES',
    'permission' => 'App\\Models\\Role\\Permission',
    'permissions_table' => 'T_PERMISSIONS',
    'permission_role_table' => 'T_PERMISSION_ROLE',
    'role_user_table' => 'T_ROLE_USER',
    'user_foreign_key' => 'user_id',
    'role_foreign_key' => 'role_id',
  ),
  'excel' => 
  array (
    'cache' => 
    array (
      'enable' => true,
      'driver' => 'memory',
      'settings' => 
      array (
        'memoryCacheSize' => '32MB',
        'cacheTime' => 600,
      ),
      'memcache' => 
      array (
        'host' => 'localhost',
        'port' => 11211,
      ),
      'dir' => 'D:\\wamp\\www\\dalmia-lams\\storage\\cache',
    ),
    'properties' => 
    array (
      'creator' => 'Maatwebsite',
      'lastModifiedBy' => 'Maatwebsite',
      'title' => 'Spreadsheet',
      'description' => 'Default spreadsheet export',
      'subject' => 'Spreadsheet export',
      'keywords' => 'maatwebsite, excel, export',
      'category' => 'Excel',
      'manager' => 'Maatwebsite',
      'company' => 'Maatwebsite',
    ),
    'sheets' => 
    array (
      'pageSetup' => 
      array (
        'orientation' => 'portrait',
        'paperSize' => '9',
        'scale' => '100',
        'fitToPage' => false,
        'fitToHeight' => true,
        'fitToWidth' => true,
        'columnsToRepeatAtLeft' => 
        array (
          0 => '',
          1 => '',
        ),
        'rowsToRepeatAtTop' => 
        array (
          0 => 0,
          1 => 0,
        ),
        'horizontalCentered' => false,
        'verticalCentered' => false,
        'printArea' => NULL,
        'firstPageNumber' => NULL,
      ),
    ),
    'creator' => 'Maatwebsite',
    'csv' => 
    array (
      'delimiter' => ',',
      'enclosure' => '"',
      'line_ending' => '
',
      'use_bom' => false,
    ),
    'export' => 
    array (
      'autosize' => true,
      'autosize-method' => 'approx',
      'generate_heading_by_indices' => true,
      'merged_cell_alignment' => 'left',
      'calculate' => false,
      'includeCharts' => false,
      'sheets' => 
      array (
        'page_margin' => false,
        'nullValue' => NULL,
        'startCell' => 'A1',
        'strictNullComparison' => false,
      ),
      'store' => 
      array (
        'path' => 'D:\\wamp\\www\\dalmia-lams\\storage\\exports',
        'returnInfo' => false,
      ),
      'pdf' => 
      array (
        'driver' => 'DomPDF',
        'drivers' => 
        array (
          'DomPDF' => 
          array (
            'path' => 'D:\\wamp\\www\\dalmia-lams\\vendor/dompdf/dompdf/',
          ),
          'tcPDF' => 
          array (
            'path' => 'D:\\wamp\\www\\dalmia-lams\\vendor/tecnick.com/tcpdf/',
          ),
          'mPDF' => 
          array (
            'path' => 'D:\\wamp\\www\\dalmia-lams\\vendor/mpdf/mpdf/',
          ),
        ),
      ),
    ),
    'filters' => 
    array (
      'registered' => 
      array (
        'chunk' => 'Maatwebsite\\Excel\\Filters\\ChunkReadFilter',
      ),
      'enabled' => 
      array (
      ),
    ),
    'import' => 
    array (
      'heading' => 'slugged',
      'startRow' => 1,
      'separator' => '_',
      'includeCharts' => false,
      'to_ascii' => true,
      'encoding' => 
      array (
        'input' => 'UTF-8',
        'output' => 'UTF-8',
      ),
      'calculate' => true,
      'ignoreEmpty' => false,
      'force_sheets_collection' => false,
      'dates' => 
      array (
        'enabled' => true,
        'format' => false,
        'columns' => 
        array (
        ),
      ),
      'sheets' => 
      array (
        'test' => 
        array (
          'firstname' => 'A2',
        ),
      ),
    ),
    'views' => 
    array (
      'styles' => 
      array (
        'th' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'strong' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'b' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'i' => 
        array (
          'font' => 
          array (
            'italic' => true,
            'size' => 12,
          ),
        ),
        'h1' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 24,
          ),
        ),
        'h2' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 18,
          ),
        ),
        'h3' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 13.5,
          ),
        ),
        'h4' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 12,
          ),
        ),
        'h5' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 10,
          ),
        ),
        'h6' => 
        array (
          'font' => 
          array (
            'bold' => true,
            'size' => 7.5,
          ),
        ),
        'a' => 
        array (
          'font' => 
          array (
            'underline' => true,
            'color' => 
            array (
              'argb' => 'FF0000FF',
            ),
          ),
        ),
        'hr' => 
        array (
          'borders' => 
          array (
            'bottom' => 
            array (
              'style' => 'thin',
              'color' => 
              array (
                0 => 'FF000000',
              ),
            ),
          ),
        ),
      ),
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\wamp\\www\\dalmia-lams',
      ),
      'D3' => 
      array (
        'driver' => 'local',
        'root' => 'E:/Koushik/dalmia-lams/LAND RECORD',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'D:\\wamp\\www\\dalmia-lams\\storage\\app/public',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => 'your-key',
        'secret' => 'your-secret',
        'region' => 'your-region',
        'bucket' => 'your-bucket',
      ),
    ),
  ),
  'geoserver' => 
  array (
    'ADMIN_NAME' => 'administrator',
  ),
  'jsvalidation' => 
  array (
    'view' => 'jsvalidation::bootstrap',
    'form_selector' => 'form',
    'focus_on_error' => false,
    'duration_animate' => 1000,
    'disable_remote_validation' => false,
    'remote_validation_field' => '_jsvalidation',
  ),
  'laravel-menu' => 
  array (
    'settings' => 
    array (
      'default' => 
      array (
        'auto_activate' => true,
        'activate_parents' => true,
        'active_class' => 'active',
        'restful' => false,
        'cascade_data' => true,
        'rest_base' => '',
        'active_element' => 'item',
      ),
    ),
    'views' => 
    array (
      'bootstrap-items' => 'laravel-menu::bootstrap-navbar-items',
    ),
  ),
  'mail' => 
  array (
    'driver' => 'smtp',
    'host' => '192.168.40.140',
    'port' => '25',
    'from' => 
    array (
      'address' => 'admin@landmgmt.dalmiabharat.com',
      'name' => 'Land Admin',
    ),
    'encryption' => NULL,
    'username' => 'landmgmt@dalmiabharat.com',
    'password' => 'Dalmia@2020',
    'sendmail' => '/usr/sbin/sendmail -bs',
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'expire' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'ttr' => 90,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => 'your-public-key',
        'secret' => 'your-secret-key',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'expire' => 90,
      ),
    ),
    'failed' => 
    array (
      'database' => 'pgsql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
    ),
    'mandrill' => 
    array (
      'secret' => NULL,
    ),
    'ses' => 
    array (
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ),
    'sparkpost' => 
    array (
      'secret' => NULL,
    ),
    'stripe' => 
    array (
      'model' => 'App\\User',
      'key' => NULL,
      'secret' => NULL,
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => 120,
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'D:\\wamp\\www\\dalmia-lams\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
    'http_only' => true,
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'D:\\wamp\\www\\dalmia-lams\\resources\\views',
    ),
    'compiled' => 'D:\\wamp\\www\\dalmia-lams\\storage\\framework\\views',
  ),
);

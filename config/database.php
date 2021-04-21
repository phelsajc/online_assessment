<?php

return [

    'default' => env('DB_CONNECTION', 'bizbox'),
    
    'connections' => [
     
        'bizbox' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_SQLSRV', '192.168.110.170'),
            //'host' => env('DB_HOST_SQLSRV', '192.168.70.83'),
            'port' => env('DB_PORT_SQLSRV', '1433'),
            //'database' => env('DB_DATABASE_SQLSRV', 'bizbox8'),
            'database' => env('DB_DATABASE_SQLSRV', 'TrainingDB_bizbox20200224'),
            'username' => env('DB_USERNAME_SQLSRV', 'sa'),
            'password' => env('DB_PASSWORD_SQLSRV', 's@password1'),
            'charset' => 'utf8',
            'prefix' => '',
        ], 
        
        /* 'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '192.168.70.90'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'philhealth_cleaimform_test'),            
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', 'pgadmin888!?'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ], */

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '192.168.70.90'),
            'port' => env('DB_PORT', '5432'),
            //'database' => env('DB_DATABASE', 'philhealth_claimform'),
            'database' => env('DB_DATABASE', 'testdb_ctx'),            
            'username' => env('DB_USERNAME', 'postgres'),
            'password' => env('DB_PASSWORD', 'pgadmin888!?'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'infotxt' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST_SQLSRV', '192.168.70.50'),
            'port' => env('DB_PORT_SQLSRV', '1433'),
            'database' => env('DB_DATABASE_SQLSRV', 'Infotxt'),
            'username' => env('DB_USERNAME_SQLSRV', 'sa'),
            'password' => env('DB_PASSWORD_SQLSRV', 'Infotxt1'),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ],
      
    ],

];

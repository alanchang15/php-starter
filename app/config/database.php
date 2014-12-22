<?php

return array(
    'default' => 'mysql',
    'connections' => array(
        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'starter',
            'username'  => 'root',
            'password'  => 'a4266000',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),
        'sqlite' => array(
            'driver'   => 'sqlite',
            'database' => APP_DIR . 'database/production.sqlite',
            'prefix'   => '',
        ),
        'pgsql' => array(
            'driver'   => 'pgsql',
            'host'     => 'localhost',
            'database' => 'forge',
            'username' => 'forge',
            'password' => '',
            'charset'  => 'utf8',
            'prefix'   => '',
            'schema'   => 'public',
        ),
        'sqlsrv' => array(
            'driver'   => 'sqlsrv',
            'host'     => 'localhost',
            'database' => 'database',
            'username' => 'root',
            'password' => '',
            'prefix'   => '',
        ),
    )
);
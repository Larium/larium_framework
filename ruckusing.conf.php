<?php
date_default_timezone_set('UTC');

//----------------------------
// DATABASE CONFIGURATION
//----------------------------

/*

Valid types (adapters) are Postgres & MySQL:

'type' must be one of: 'pgsql' or 'mysql' or 'sqlite'

*/

$db = include __DIR__ . '/config/database.php';
return array(
    'db' => array(
        'development' => array(
            'type'      => 'mysql',
            'host'      => $db['development']['host'],
            'port'      => $db['development']['port'],
            'database'  => $db['development']['database'],
            'user'      => $db['development']['username'],
            'password'  => $db['development']['password'],
            'charset'   => 'utf8',
            //'directory' => 'custom_name',
            //'socket' => '/var/run/mysqld/mysqld.sock'
        ),

        'test'  => array(
            'type'      => 'mysql',
            'host'      => $db['test']['host'],
            'port'      => $db['test']['port'],
            'database'  => $db['test']['database'],
            'user'      => $db['test']['username'],
            'password'  => $db['test']['password'],
            'charset'   => 'utf8',

        ),

        'production'  => array(
            'type'      => 'mysql',
            'host'      => $db['production']['host'],
            'port'      => $db['production']['port'],
            'database'  => $db['production']['database'],
            'user'      => $db['production']['username'],
            'password'  => $db['production']['password'],
            'charset'   => 'utf8',
        )

    ),
    'migrations_dir' => array('default' => RUCKUSING_WORKING_BASE . '/migrations'),
    'db_dir' => RUCKUSING_WORKING_BASE . DIRECTORY_SEPARATOR . 'db',
    'log_dir' => RUCKUSING_WORKING_BASE . DIRECTORY_SEPARATOR . 'logs',
    'ruckusing_base' => __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'ruckusing' .  DIRECTORY_SEPARATOR . 'ruckusing-migrations'
);

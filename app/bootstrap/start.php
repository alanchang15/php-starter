<?php

ini_set('display_errors', 1);
error_reporting(-1);

$root = dirname(dirname(__DIR__));
$base_url = ($root == $_SERVER['DOCUMENT_ROOT'])
    ? 'http://' . $_SERVER['HTTP_HOST'] . '/'
    : 'http://' . $_SERVER['HTTP_HOST'] . '/' . str_replace($_SERVER['DOCUMENT_ROOT'], '', $root);

define('BASE_URL', $base_url);
define('ROOT_DIR', $root . '/');
define('APP_DIR', $root . '/app/');
define('VIEW_DIR', $root . '/app/views/');
define('STORAGE_DIR', $root . '/app/storage/');

require_once(ROOT_DIR . 'vendor/autoload.php');

$app = new Engine;
Facade::setFacadeApplication($app);
Facade::registerAliases();

App::bootEloquent(App::get('database'));
App::bootModules();

require_once(APP_DIR . 'bootstrap/app.php');
(file_exists($routes_php = APP_DIR . 'routes.php')) AND require_once($routes_php);
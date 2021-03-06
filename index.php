<?php
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;
use Phroute\Phroute\RouteParser;
use Illuminate\Database\Capsule\Manager as Capsule;

require_once 'vendor/autoload.php';
session_start();

define('BASE_URL', 'http://ecom.test/');

$capsule = new Capsule();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'llc04_ecommerce',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

//$users = Capsule::table('users')->get();
//echo '<pre>';
//var_dump($users);die();
//echo '</pre>';
//die();
$router = new RouteCollector(new RouteParser());

require_once __DIR__ . '/routes.php';

$dispatcher = new Dispatcher($router->getData());
try{
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
} catch (HttpRouteNotFoundException $e){
   echo $e->getMessage();
   die();
} catch (HttpMethodNotAllowedException $e) {
    echo $e->getMessage();
    die();
}
echo $response;


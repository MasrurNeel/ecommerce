<?php
use Phroute\Phroute\RouteCollector;

$router->filter('auth', function(){
    if(!isset($_SESSION['user']))
    {
        $errors[] = 'You are not logged in.';
        $_SESSION['errors']= $errors;
        header('Location: /login');
        exit();
    }
});
$router->controller('/', \App\Controllers\Frontend\HomeController::class);
$router->controller('/users', \App\Controllers\Frontend\UsersController::class);

$router->group(['before' => 'auth'], function(RouteCollector $router) {
    $router->controller('/dashboard', \App\Controllers\Backend\DashboardController::class);
});
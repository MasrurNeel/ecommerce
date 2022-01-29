<?php
namespace App\Controllers;
if(!function_exists('view')){
    function view($view = 'home')
    {
        if (!empty($view)) {
            return 'No view passed';
        }
        require_once __DIR__ . '/../../views/' . $view . '.php';
    }
}
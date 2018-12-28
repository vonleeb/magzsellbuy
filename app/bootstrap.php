<?php

namespace App;

use App\Core\Route;
use App\Core\Controller;
use App\Core\Model;
use App\Core\View;


define('PATH', dirname(__DIR__) . '/');
spl_autoload_register(function ($class) {
    $path = strtolower(str_replace('\\', '/', PATH . $class . '.php'));
    if (file_exists($path)) {
        require_once $path;
    }
});


Route::start();
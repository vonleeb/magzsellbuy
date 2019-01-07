<?php

namespace App;

use App\Core\Route;
use App\Core\Controller;
use App\Core\Model;
use App\Core\View;


define('PATH', dirname(__DIR__) . '/');
spl_autoload_register(function ($class) {
    $p = strtolower($class);
    $p = explode('\\', $p);
//    array_push($p , ucfirst(array_pop($p)));
    array_push($p , mb_convert_case((array_pop($p)), MB_CASE_TITLE));
    $p = implode('\\',$p);
    $path = str_replace('\\', '/', strtolower(PATH) . $p . '.php');
    if (file_exists($path)) {
        require_once $path;
    }
});


Route::start();
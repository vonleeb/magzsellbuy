<?php

namespace App\Core;

class Route
{
    public static function start()
    {
        $controllerName = 'Controller_Main';
        $controllerAction = 'index';

         $path = parse_url(($_SERVER['REQUEST_URI']), PHP_URL_PATH);
         $path = explode('/', $path);
         if( ! empty ($path[1])){
             $controllerName = 'Controller_' . $path[1];
         }
         if( ! empty ($path[2])){
             $controllerAction = $path[2];
         }

         $controllerFile = strtolower(str_replace( '\\', '/',PATH . 'app/controllers/' . $controllerName . '.php' ) );

         if(file_exists($controllerFile)){
             $controllerName = 'App\Controllers\\' . $controllerName;
             $controller = new $controllerName;
             if(method_exists($controller, $controllerAction)){
                 $controller->$controllerAction();
             }else{
                 // надо как-то обработать отсутсвие метода. А пока вызываем базовый метод контроллера;
                 $controller->index();
             }
         }else{
             // как-нибудь надо будет отработать отсутсвие файла. А пока переходим на 404 страничку.
             $controller = new \App\Controllers\Controller_404;
             $controller->index();
         }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: pTawKa
 * Date: 26.12.2018
 * Time: 18:04
 */

namespace App\Core;

class View
{
    public function render($content_view, $base_view, $data = null)
    {

        if(is_array($data)) {
            // преобразуем элементы массива в переменные
            extract($data);
        }

        require_once 'app/views/'.$base_view;
    }
}
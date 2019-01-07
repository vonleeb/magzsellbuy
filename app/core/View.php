<?php


namespace App\Core;

class View
{
    public function render($content_view, $base_view, $data = null)
    {

        if(is_array($data)) {
            extract($data);
        }

        require_once 'app/views/'.$base_view;
    }

}
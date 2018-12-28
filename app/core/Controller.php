<?php
/**
 * Created by PhpStorm.
 * User: pTawKa
 * Date: 26.12.2018
 * Time: 18:05
 */

namespace App\Core;

class Controller
{
    public $model;
    public $view;

    public function __construct()
    {
        $this->view = new View();
    }

    public function action_index()
    {
    }
}
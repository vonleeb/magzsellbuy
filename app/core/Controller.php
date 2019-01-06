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

    public function index()
    {
        session_start();
        $this->view->render('error_404_view.php', 'template_view.php');
        session_write_close();
    }
}
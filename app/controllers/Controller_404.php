<?php

namespace App\Controllers;

use App\Core\Controller;

class Controller_404 extends Controller
{
    public function index()
    {
        $this->view->render('error_404_view.php', 'template_view.php');
    }
}
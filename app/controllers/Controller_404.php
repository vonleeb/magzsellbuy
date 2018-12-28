<?php

namespace App\Controllers;

use App\Core\Controller;

class Controller_404 extends Controller
{
    public function index()
    {
        $this->view->render('error_404.php', 'template_view.php');
    }
}
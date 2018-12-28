<?php
/**
 * Created by PhpStorm.
 * User: pTawKa
 * Date: 27.12.2018
 * Time: 20:27
 */

namespace App\Controllers;

use App\Core\Controller;

class Controller_Main extends Controller
{
    public function index()
    {
        $this->view->render('main_view.php', 'template_view.php', ['test' => '123']);
    }
}
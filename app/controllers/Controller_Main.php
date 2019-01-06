<?php


namespace App\Controllers;

use App\Core\Controller;
use app\models\Product;

class Controller_Main extends Controller
{
    public function index()
    {
        session_start();
        $products = new Product();
        $data['products'] = $products->getAll();
        if($_SESSION['auth'] === TRUE){
            $this->view->render('main_auth_view.php', 'template_view.php', $data);
        }else $this->view->render('main_no_auth_view.php', 'template_view.php', $data);
        session_write_close();
    }
}
<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class Controller_Main extends Controller
{
    public function index()
    {
        session_start();
        if(isset($_SESSION['msg'])) {
            $data['msg'] = $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        $products = new Product();
        $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
        $data['products'] = $products->getAll(NULL , $sort);
        $data['sort'] = $sort;
        $this->view->render('main_view.php', 'template_view.php', $data);
        session_write_close();
    }
}
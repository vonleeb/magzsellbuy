<?php


namespace app\controllers;


use App\Core\Controller;
use app\models\Product;

class Controller_Product extends Controller
{
    public function get()
    {
        session_start();
        $product = new Product();
        if($product->getByID() === FALSE){
            $data['msg'] = $product->errors;
            $this->view->render('product/prod_fail_view.php', 'template_view.php', $data);
        }else{
            $data['product'] = $product;
            $this->view->render('product/prod_succ_view.php', 'template_view.php', $data);
        }
        session_write_close();
    }

    public function ins()
    {
        session_start();
        if($_SESSION['auth'] === TRUE){
        $this->view->render('ins_prod_view.php', 'template_view.php');
        }else $this->view->render('error_404_view.php', 'template_view.php');
        session_write_close();
    }

    public function add()
    {
        $product = new Product();
        session_start();
        if($_SESSION['auth'] === TRUE){
        try{
        if($product->validateForm() !== FALSE){
                $pathFile = $product->moveFile();
                if($pathFile !==FALSE){
                   if($product->insert($pathFile) !== FALSE){
                       $data['msg'] = 'Товар был успешно добавлен';
                       $this->view->render('main_auth_view.php', 'template_view.php', $data);
                   }else throw new \Exception();
                }else throw new \Exception();
        }else throw new \Exception();
        }
        catch(\Exception $e){
            $data['msg'] = $product->errors;
            $this->view->render('ins_prod_view.php', 'template_view.php', $data);

        }
        }else $this->view->render('error_404_view.php', 'template_view.php');
        session_write_close();
    }
}
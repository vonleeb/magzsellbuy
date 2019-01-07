<?php


namespace app\controllers;


use App\Core\Controller;
use App\Core\Route;
use app\models\Product;

class Controller_Product extends Controller
{
    public function buyprod()
    {
        $this->prod('buy');
    }

    public function sellprod()
    {
        $this->prod('sell');
    }

    public function myprod()
    {
        $this->prod('my');
    }

    public function prod( string $query=NULL)
    {
        session_start();
        $view='error_404_view.php';
        if (isset($_SESSION['auth']) and $_SESSION['auth'] === TRUE) {
            $product = new Product();
            $allMyProd = $product->getAllByUserID($_SESSION['user_id'], $query);
            if ($allMyProd === FALSE) {
                $data['msg'] = $product->errors;
            } else {
//                array_walk($allMyProd, $product->clean($allMyProd));
                $data['products'] = $allMyProd;
            }
            if($query == 'sell'){ $view='product/sb_product_view.php'; $data['sb'] = 'проданных'; $data['bs']='Покупатель';}
            if($query == 'buy'){ $view='product/sb_product_view.php'; $data['sb'] = 'купленных'; $data['bs']='Продавец';}
            if($query == 'my') $view='product/my_product_view.php';
            $this->view->render($view, 'template_view.php', $data);
        } else $this->view->render('error_404_view.php', 'template_view.php');
        session_write_close();
    }

    public function buy()
    {
        session_start();
        if (isset($_SESSION['auth']) and $_SESSION['auth'] === TRUE) {
            $buyProduct = new Product();
            if ($buyProduct->buyByID($_SESSION['user_id'])) {
               $_SESSION['msg'] = 'Товар успешно куплен';
            } else {
                $_SESSION['msg'] = $buyProduct->errors;
            }
            Route::redirect('/product/get/?id='.$_GET['id']);
        } else $this->view->render('error_404_view.php', 'template_view.php');
        session_write_close();
    }

    public function buyAjax()
    {
            if(isset($_GET['user']) && $_GET['user'] != 0){
            $buyProduct = new Product();
            if ($buyProduct->buyByID((int)$_GET['user'])) {
                echo 'Товар успешно куплен';
            } else echo $buyProduct->errors;
            }else echo 'Для покупки необходимо авторизоваться';
    }

    public function get()
    {
        session_start();
        $product = new Product();
        $oneProd = $product->getByID();
        if ($oneProd === FALSE) $data['msg'] = $product->errors;
        $data['product'] = $oneProd;
        $data['user_id'] = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);
        $this->view->render('product/card_view.php', 'template_view.php', $data);
        session_write_close();
    }

    public function ins()
    {
        session_start();
        if (isset($_SESSION['auth']) and $_SESSION['auth'] === TRUE) {
            $this->view->render('ins_prod_view.php', 'template_view.php');
        } else $this->view->render('error_404_view.php', 'template_view.php');

    }

    public function edit()
    {
        session_start();
        if (isset($_SESSION['auth']) and $_SESSION['auth'] === TRUE) {
            $product = new Product();
            $editProd = $product->getByID(true, $_SESSION['user_id']);
            if($editProd === FALSE) $data['msg'] = $product->errors;
            $data['edit'] = $editProd;
            $this->view->render('product/edit_prod_view.php', 'template_view.php', $data);
        } else $this->view->render('error_404_view.php', 'template_view.php');
        session_write_close();
    }

    public function save()
    {
        $product = new Product();
        session_start();
        if (isset($_SESSION['auth']) and $_SESSION['auth'] === TRUE) {
            $editProdID = $product->getByID(true, $_SESSION['user_id']);
            try {
                if($_POST['file'] == 'on'){
                    $noFile = TRUE;
                }else $noFile = FALSE;
                if ($product->validateForm($noFile) !== FALSE) {
                    $pathFile = $product->moveFile($noFile);
                    if ($pathFile !== FALSE) {
                        if ($product->update($pathFile, $editProdID) !== FALSE) {
                            $_SESSION['msg'] = 'Товар был успешно изменен.';
                            Route::redirect('/product/myprod');
                        } else throw new \Exception();
                    } else throw new \Exception();
                } else throw new \Exception();
            } catch (\Exception $e) {
                $_SESSION['msg'] = $product->errors;
                Route::redirect('/product/edit/?id='.$_GET['id']);
            }
        } else $this->view->render('error_404_view.php', 'template_view.php');
        session_write_close();

    }

    public function add()
    {
        $product = new Product();
        session_start();
        if (isset($_SESSION['auth']) and $_SESSION['auth'] === TRUE) {
            try {
                if ($product->validateForm() !== FALSE) {
                    $pathFile = $product->moveFile();
                    if ($pathFile !== FALSE) {
                        if ($product->insert($pathFile) !== FALSE) {
                            $_SESSION['msg'] = 'Товар был успешно добавлен';
                            Route::redirect();
                        } else throw new \Exception();
                    } else throw new \Exception();
                } else throw new \Exception();
            } catch (\Exception $e) {
                $data['msg'] = $product->errors;
                $this->view->render('ins_prod_view.php', 'template_view.php', $data);

            }
        } else $this->view->render('error_404_view.php', 'template_view.php');
        session_write_close();
    }
}
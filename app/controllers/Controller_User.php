<?php


namespace app\controllers;


use App\Core\Controller;
use App\Core\Route;
use app\models\User;

class Controller_User extends Controller
{
    public function log()
    {
        $this->view->render('auth/login_view.php', 'template_view.php');
    }

    public function reg()
    {
        $this->view->render('auth/register_view.php', 'template_view.php');
    }

    public function register()
    {
        session_start();
        if($_SESSION['auth'] === TRUE){
            Route::redirect();
        }else{
            $user = new User();
            $userValidate = $user->validateForm();
            if( $userValidate === TRUE ){
                $user_id = $user->userCreate();
                if($user_id !== FALSE){
                    $newUser = $user->searchUserByID($user_id);
                    $_SESSION['auth'] = TRUE;
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $newUser['fio'];
                    $_SESSION['email'] = $newUser['email'];
                    Route::redirect();
                }else{
                    $data['msg'] = 'Такой пользователь уже существует. Выберите другой е-майл.';
                    $this->view->render('auth/register_view.php', 'template_view.php', $data);
                }
            }else{
                $data['msg'] = $userValidate;
                $this->view->render('auth/register_view.php', 'template_view.php', $data);
            }
        }
    }

    public function login()
    {
        $guest = new User();
        $user = $guest->userLogin();
        if($user !== FALSE){
            session_start();
            $_SESSION['auth'] = TRUE;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['fio'];
            $_SESSION['email'] = $user['email'];
            session_write_close();
            Route::redirect();
        }else{
            $data['msg'] = 'Ошибка авторизации.';
            $this->view->render('auth/login_view.php', 'template_view.php', $data);
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        Route::redirect();
    }

}
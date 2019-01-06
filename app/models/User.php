<?php
/**
 * Created by PhpStorm.
 * User: pTawKa
 * Date: 04.01.2019
 * Time: 16:46
 */

namespace app\models;


use App\Core\Model;

class User extends Model
{

    public function validateForm()
    {
        $ruleFields = ['email' => array('min' => 5, 'max' => 150, 'name' => 'е-майл'),
                        'fio' => array('min' => 15, 'max' => 250, 'name' => 'ФИО'),
                        'phone' => array('min' => 5, 'max' => 40, 'name' => 'телефон'),
                        'password' => array('min' => 5, 'max' => 30, 'name' => 'пароль'),
        ];
        $errors = array();
        foreach ($ruleFields as $field => $minMaxName) {
            if ( ! isset($_POST[$field])) {
                $errors[$field] =  'Ошибка! Поле: <' . $minMaxName['name'] . '> не было заполнено';
            }
            $length = (mb_strlen($_POST[$field]) < $minMaxName['min'] || mb_strlen($_POST[$field]) > $minMaxName['max']);
            if ( $length  && isset($errors[$field]) !== TRUE) {
                $errors[$field] = 'Ошибка! Поле: <' . $minMaxName['name'] . '> должно содержать от ' . $minMaxName['min'] . ' до ' . $minMaxName['max'] . ' символов.';
            }

        }
        if ($this->clean($_POST['password']) != $this->clean($_POST['password_copy'])) {
            $errors['password'] = 'Введенные пароли не совпадают. Повторите попытку.';
        }
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === FALSE && isset($errors['email']) !== TRUE) {
            $errors['email'] = 'Неправильно введен е-майл.';
        }

        if (empty($errors)) {
            return true;
        } else return $errors;
    }

    public function userCreate()
    {
        try {
            if ($this->SearchUser($this->clean($_POST['email'])) === FALSE) {
                $sql = "INSERT INTO users(email, password, fio, phone) VALUES (? , ? , ? , ?)";
                if ($query = $this->mysqli->prepare($sql)) {
                    $query->bind_param('ssss', $this->clean($_POST['email']), md5($this->clean($_POST['password'])), $this->clean($_POST['fio']), $this->clean($_POST['phone']));
                    $query->execute();
                    $result = $query->insert_id;
                    return $result;
                } else {
                    throw new \Exception('Ощибка SQL запроса');
                }
            } else {
                throw new \Exception('Такой пользователь уже существует');
            }
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function userLogin()
    {
        $user = $this->SearchUser($_POST['email']);
        if ($user !== FALSE) {
            if ($user['password'] == md5($this->clean($_POST['password']))) {
                return $user;
            } else return false;
        } else return false;
    }

    private function SearchUser($userName)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        if ($query = $this->mysqli->prepare($sql)) {
            $query->bind_param('s', $this->clean($userName));
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            if(empty($row['id'])){
            return false;
            }else return $row;

        } else return false;
    }

    public function searchUserByID(int $id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        if ($query = $this->mysqli->prepare($sql)) {
            $query->bind_param('i', $this->clean($id));
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            return $row;
        } else return false;
    }


}
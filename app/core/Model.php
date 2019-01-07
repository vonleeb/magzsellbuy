<?php
/**
 * Created by PhpStorm.
 * User: pTawKa
 * Date: 26.12.2018
 * Time: 18:03
 */

namespace App\Core;

class Model
{
    public $errors = array();
    protected $mysqli;

    public function __construct()
    {
        require_once PATH . '/config/config.php';
        $this->mysqli = new \mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);
        if ($this->mysqli->connect_error) {
            die('Ошибка соединения с БД');
        }
        $this->mysqli->set_charset("utf8");
    }

    public function &clean( &$value = "")
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);

        return $value;
    }
}
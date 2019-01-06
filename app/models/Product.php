<?php


namespace app\models;


use App\Core\Model;

class Product extends Model
{
    public function getAll()
    {
        try {
            $sql = "SELECT * FROM products WHERE quantity > 0";
            $products = array();
            if ($result = $this->mysqli->query($sql)) {
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                return $products;
            } else throw new \Exception('Произошла ошибка');
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function getByID()
    {
        try {
            $sql = "SELECT * FROM products WHERE quantity > 0 and id=?";
            if ($query = $this->mysqli->prepare($sql)) {
                $query->bind_param('i', $this->clean((int)$_GET['id']));
                $query->execute();
                $result = $query->get_result();
                $row = $result->fetch_assoc();
                if(empty($row['id'])){
                    throw new \Exception('Товара не существует.');
                }else return $row;
            } else throw new \Exception('Произошла ошибка запроса');
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function insert($path = '/public/uploads/no_photo.jpg')
    {
        try {
            $sql = "INSERT INTO products(name, description, price, quantity, image_url, user_id) VALUES (? , ? , ? , ? , ?, ?)";
            if ($query = $this->mysqli->prepare($sql)) {
                $query->bind_param('ssdisi', $this->clean($_POST['title']), $this->clean($_POST['description']), $this->clean(floatval(str_replace(',', '.', $_POST['price']))), $this->clean((int)$_POST['quantity']), $path, $_SESSION['user_id']);
                $query->execute();
                $result = $query->insert_id;
                return $result;
            } else {
                throw new \Exception('Произошла ошибка');
            }
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function validateForm()
    {
        $ruleFields = ['title' => array('min' => 5, 'max' => 150, 'name' => 'название товара'),
            'price' => array('min' => 1, 'max' => 10, 'name' => 'цена'),
            'quantity' => array('min' => 1, 'max' => 3, 'name' => 'количество'),
            'description' => array('min' => 5, 'max' => 111111111111111, 'name' => 'краткое описание'),
        ];
        $errors = array();
        foreach ($ruleFields as $field => $minMaxName) {
            if (!isset($_POST[$field])) {
                $errors[$field] = 'Ошибка! Поле: <' . $minMaxName['name'] . '> не было заполнено';
            }
            $length = (mb_strlen($_POST[$field]) < $minMaxName['min'] || mb_strlen($_POST[$field]) > $minMaxName['max']);
            if ($length && isset($errors[$field]) !== TRUE && $field != 'description') {
                $errors[$field] = 'Ошибка! Поле: <' . $minMaxName['name'] . '> должно содержать от ' . $minMaxName['min'] . ' до ' . $minMaxName['max'] . ' символов.';
            }

        }
        if((int)$_POST['quantity'] > 100 || (int)$_POST['quantity'] < 0 ) $errors['quantity'] = 'Неправильное количество товара, введите от 0 до 100';
        if (strlen($_POST['description']) > 6500 && isset($errors['description']) === FALSE) {
            $errors['description'] = 'Слишком большое описание, сократите!';
        }
        try {
            if (is_uploaded_file($_FILES['file']['tmp_name']) === FALSE) {
                switch ($_FILES['file']['error']) {
                    case 0 :
                        throw new \Exception('Файл загружен');
                    case 1 :
                        throw new \Exception('Размер принятого файла превысил максимально допустимый размер');
                    case 2 :
                        throw new \Exception('Размер загружаемого файла превысил максимальное значение!');
                    case 3 :
                        throw new \Exception('Загружаемый файл был получен только частично. Повторите загрузку.');
                    case 4 :
                        throw new \Exception('Не удалось загрузить файл');
                    default :
                        throw new \Exception('Не удалось загрузить файл. Произошла неизвестная ошибка.');
                }
            }
            $mimeType = exif_imagetype($_FILES['file']['tmp_name']);
            $checkType = ($mimeType == IMAGETYPE_GIF || $mimeType == IMAGETYPE_PNG || $mimeType == IMAGETYPE_JPEG);
            if ($checkType === FALSE && isset($errors['file']) === FALSE) throw new \Exception('Неправильный тип картинки. Можно загружать только png, jpeg, gif');
        } catch (\Exception $e) {
            $errors['file'] = $e->getMessage();
        }
        if (empty($errors)) {
            return true;
        } else {
            $this->errors = $errors;
            return false;
        }
    }

    public function moveFile()
    {
        $pathMove = 'public/uploads/' . $_SESSION['user_id'];
        $fileName = date("YmdHis") . '_' . $_FILES['file']['name'];
        $path = '/public/uploads/' . $_SESSION['user_id'] . '/' . $fileName;
        try {
            if (is_uploaded_file($_FILES['file']['tmp_name']) === FALSE) throw new \Exception('Ошибка загрузки файла');
            if (file_exists($pathMove) === FALSE) {
                if (mkdir($pathMove, 0777) === FALSE) throw new \Exception('Ошибка создания директории');
            }
            if (move_uploaded_file($_FILES['file']['tmp_name'], $pathMove . '/' . $fileName) === FALSE) throw new \Exception('Ошибка перемещения файла');
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
        return $path;
    }
}
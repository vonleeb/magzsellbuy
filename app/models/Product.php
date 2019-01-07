<?php


namespace App\Models;


use App\Core\Model;

class Product extends Model
{

    public function buyByID(int $cstID = 0): bool
    {
        try {
            $product = $this->checkQuantity();
            if ($product !== FALSE) {
                if ($product['user_id'] == $cstID) throw new \Exception('Произошла ошибка: нельзя купить свой товар');
                $quantity = $product['quantity'];
                --$quantity;
                $sql = "UPDATE products SET quantity=" . $quantity . " WHERE id=" . $product['id'];
                if ($query = $this->mysqli->query($sql)) {
                    $sql = "SELECT id FROM sales WHERE customer_id=" . $cstID . " AND product_id=" . $_GET['id'];
                    if ($query = $this->mysqli->query($sql)) {
                        $row = $query->fetch_assoc();
                        if (empty($row['id'])) {
                            $sql = "INSERT INTO sales(customer_id,seller_id,product_id,quantity) VALUES(" .
                                $cstID . "," .
                                $product['user_id'] . "," . $product['id'] . ",1)";
                        } else {
                            $sql = "UPDATE sales SET quantity=quantity+1 WHERE id=" . $row['id'];
                        }
                        if ($query = $this->mysqli->query($sql)) {
                            return true;
                        } else throw new \Exception('Произошлка ошибка 1');
                    } else throw new \Exception('Произошла ошибка 2');
                } else throw new \Exception('Произошла ошибка: не удалось купить товар');
            } else throw new \Exception('Товар закончился.');
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function checkQuantity()
    {
        $sql = 'SELECT id,quantity,user_id FROM products WHERE quantity > 0 AND id = ?';
        if ($checkQuantity = $this->mysqli->prepare($sql)) {
            $checkQuantity->bind_param('i', $this->clean($_GET['id']));
            $checkQuantity->execute();
            $result = $checkQuantity->get_result();
            $product = $result->fetch_assoc();
            if (empty($product['id'])) {
                return false;
            } else return $product;
        } else return false;
    }

    public function getAllByUserID(int $id, string $qry = NULL)
    {
        try {
            $sql = "SELECT products.id,image_url,name,price,sales.quantity,sale_date,email,fio,phone FROM sales";
            if ($qry == 'my') $sql = "SELECT * FROM products WHERE quantity > 0 AND user_id =" . $id;
            if ($qry == 'sell') $sql .= " INNER JOIN users ON 
  customer_id=users.id INNER 
  JOIN products ON product_id=products.id WHERE seller_id=" . $id;
            if ($qry == 'buy') $sql .= "  INNER JOIN users ON 
  seller_id=users.id INNER 
  JOIN products ON product_id=products.id WHERE customer_id=" . $id;
            $products = array();
            if ($result = $this->mysqli->query($sql)) {
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
                if (empty($products)) {
                    throw new \Exception('Товара не существует.');
                } else return $products;
            } else throw new \Exception('Произошла ошибка');
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function getAll(string $sqlQuery = NULL, string $sort = NULL)
    {
        try {
            $sql = "SELECT * FROM products WHERE quantity > 0";
            if (isset($sqlQuery)) $sql = $sqlQuery;
            switch($sort){
                case 'titleUp' : $sql.=' ORDER BY name ASC'; break;
                case 'titleDown' : $sql.=' ORDER BY name DESC'; break;
                case 'priceUp' : $sql.=' ORDER BY price ASC'; break;
                case 'priceDown' : $sql.=' ORDER BY price DESC'; break;
                case 'dateUp' : $sql.=' ORDER BY created_at ASC'; break;
                case 'dateDown' : $sql.=' ORDER BY created_at DESC'; break;
                default : $sql.=' ORDER BY created_at DESC'; break;
            }
            $products = array();
            if ($result = $this->mysqli->query($sql)) {
                while ($row = $result->fetch_assoc()) {
                    $products[] = $row;
                }
//                return $products;
                if (empty($products)) {
                    throw new \Exception('Товара не существует.');
                } else return $products;
            } else throw new \Exception('Произошла ошибка');
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function getByID(bool $edit = FALSE, int $id = NULL)
    {
        try {
            $sql = "SELECT products.id,name,description,price,quantity,image_url,fio,email,phone,users.id AS user_id FROM products INNER JOIN users ON products.user_id=users.id";
            if ($edit == FALSE) {
                $sql .= ' WHERE quantity > 0 AND products.id = ?';
            } elseif ($edit == TRUE) {
                $sql .= ' WHERE products.id = ? AND user_id=' . $id;
            }
            if ($query = $this->mysqli->prepare($sql)) {
                $query->bind_param('i', $this->clean($_GET['id']));
                $query->execute();
                $result = $query->get_result();
                $row = $result->fetch_assoc();
                if (empty($row['id'])) {
                    throw new \Exception('Не удалось найти товар.');
                } else return $row;
            } else throw new \Exception('Произошла ошибка запроса');
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function insert($path = '/public/uploads/no_photo.jpg')
    {
        try {
            $sql =
                "INSERT INTO products(name, description, price, quantity, image_url, user_id) VALUES (? , ? , ? , ? , ?, ?)";
            if ($query = $this->mysqli->prepare($sql)) {
                $query->bind_param('ssdisi', $_POST['title'], $_POST['description'],
                    $_POST['price'], $_POST['quantity'], $path, $_SESSION['user_id']);
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

    public function update($updFile, $product)
    {
        if (is_bool($updFile)) $image_url = 'image_url';
        else $image_url = "'".$updFile."'";
        try {
            $sql = "UPDATE products SET name='" . $_POST['title'] .
                    "', description='" . $_POST['description'] .
                    "', price=" . $_POST['price'] .
                    ", quantity=" . $_POST['quantity'] .
                    ", image_url=" . $image_url .
                    ", updated_at=CURRENT_TIMESTAMP ".
                    " WHERE id=" . $product['id'];
            if ($query = $this->mysqli->query($sql)) {
                return true;
            } else throw new \Exception('Произошла ошибка: не удалось обновить товар');
        } catch (\Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function validateForm(bool $miss = FALSE)
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
            $length =
                (mb_strlen($_POST[$field]) < $minMaxName['min'] || mb_strlen($_POST[$field]) > $minMaxName['max']);
            if ($length && isset($errors[$field]) !== TRUE && $field != 'description') {
                $errors[$field] =
                    'Ошибка! Поле: <' . $minMaxName['name'] . '> должно содержать от ' . $minMaxName['min'] . ' до ' .
                    $minMaxName['max'] . ' символов.';
            }

        }
        if ((int)$_POST['quantity'] > 100 || (int)$_POST['quantity'] < 0) $errors['quantity'] =
            'Неправильное количество товара, введите от 0 до 100';
        if (strlen($_POST['description']) > 6500 && isset($errors['description']) === FALSE) {
            $errors['description'] = 'Слишком большое описание, сократите!';
        }
        if ($miss == FALSE) {
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
                if ($checkType === FALSE && isset($errors['file']) ===
                    FALSE) throw new \Exception('Неправильный тип картинки. Можно загружать только png, jpeg, gif');
            } catch (\Exception $e) {
                $errors['file'] = $e->getMessage();
            }
        }
        if (empty($errors)) {
            return true;
        } else {
            $this->errors = $errors;
            return false;
        }
    }

    public function moveFile(bool $edit = FALSE)
    {
        if ($edit == FALSE) {
            $pathMove = 'public/uploads/' . $_SESSION['user_id'];
            $fileName = date("YmdHis") . '_' . $_FILES['file']['name'];
            $path = '/public/uploads/' . $_SESSION['user_id'] . '/' . $fileName;
            try {
                if (is_uploaded_file($_FILES['file']['tmp_name']) ===
                    FALSE) throw new \Exception('Ошибка загрузки файла');
                if (file_exists($pathMove) === FALSE) {
                    if (mkdir($pathMove, 0777) === FALSE) throw new \Exception('Ошибка создания директории');
                }
                if (move_uploaded_file($_FILES['file']['tmp_name'], $pathMove . '/' . $fileName) ===
                    FALSE) throw new \Exception('Ошибка перемещения файла');
            } catch (\Exception $e) {
                $this->errors = $e->getMessage();
                return false;
            }
            return $path;
        }
        return true;
    }
}
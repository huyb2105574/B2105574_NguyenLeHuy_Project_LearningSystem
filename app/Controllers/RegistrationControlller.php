<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\Registration;

class RegistrationController
{
    private $db;
    private $registrationModel;

    public function __construct()
    {
        // Kết nối với cơ sở dữ liệu
        $database = new Database();
        $this->db = $database->getConnection();
        $this->registrationModel = new Registration($this->db);
    }

    public function createRegistration()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $address = $_POST['address'];
            $date_of_birth = $_POST['date_of_birth'];
            $role = $_POST['role'];

            if ($this->registrationModel->createRegistration($full_name, $email, $phone_number, $address, $date_of_birth, $role)) {
                exit;
            } else {
                echo "Error creating registration!";
            }
        }

        require_once __DIR__ . '/../Views/Registration/register.php';
    }

    public function deleteRegistration($id = null)
    {
        if ($id === null) {
            echo "ID không tồn tại.";
            return;
        }

        if ($this->registrationModel->deleteRegistration($id)) {
            header("Location: /user/list");
            exit;
        } else {
            echo "Xóa bản đăng ký thất bại.";
        }
    }


    public function getUserData()
    {
        return $_SESSION['user'] ?? null;
    }

    public function renderView($view, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . "/../Views/$view";
        return ob_get_clean();
    }

    public function renderLayout($content, $userData = [])
    {
        $layoutPath = __DIR__ . '/../Views/layout.php';
        include $layoutPath;
    }
}

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
            $full_name = $_POST['full_name'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone_number = $_POST['phone_number'] ?? '';
            $address = $_POST['address'] ?? '';
            $date_of_birth = $_POST['date_of_birth'] ?? '';
            $role = $_POST['role'] ?? '';
            if (empty($full_name) || empty($email) || empty($role)) {
                return $this->sendJsonResponse('error', 'Các trường bắt buộc không được để trống!');
            }


            if ($this->registrationModel->createRegistration($full_name, $email, $phone_number, $address, $date_of_birth, $role)) {
                return $this->sendJsonResponse('success', 'Đăng ký thành công!');
            } else {
                return $this->sendJsonResponse('error', 'Đã xảy ra lỗi khi tạo bản đăng ký!');
            }
        }

        require_once __DIR__ . '/../Views/Registration/register.php';
    }

    public function deleteRegistration($id = null)
    {
        if ($id === null) {
            return $this->sendJsonResponse('error', 'ID không tồn tại.');
        }

        if ($this->registrationModel->deleteRegistration($id)) {
            header("Location: /user/list");
            exit;
        } else {
            return $this->sendJsonResponse('error', 'Xóa bản đăng ký thất bại.');
        }
    }

    public function getUserData()
    {
        return $_SESSION['user'] ?? null;
    }

    private function sendJsonResponse($status, $message)
    {
        header('Content-Type: application/json');
        echo json_encode(['status' => $status, 'message' => $message]);
        exit;
    }
}

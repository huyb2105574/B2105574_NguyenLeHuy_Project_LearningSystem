<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\User;
use App\Controllers\SiteController;

class UserController
{

    private $db;
    private $userModel;

    public function __construct()
    {
        // Kết nối với cơ sở dữ liệu
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User($this->db);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Lấy thông tin người dùng từ model
            $user = $this->userModel->getUserByUserName($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role']
                ];
                header('Location: /home');
                exit;
            } else {
                echo "Tên đăng nhập hoặc mật khẩu không chính xác!";
            }
        }

        // Hiển thị form đăng nhập nếu không phải POST
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once __DIR__ . '/../Views/login.php';  // Hiển thị form login
        }
    }

    public function createUser()
    {
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo "Access denied!";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            if ($this->userModel->createUser($username, $password, $full_name, $email, $role)) {
                echo "User created successfully!";
            } else {
                echo "Error creating user!";
            }
        }

        require_once __DIR__ . '/../Views/create_user.php';
    }

    public function showProfile()
    {
        if (isset($_SESSION['user'])) {
            $userData = $_SESSION['user'];

            // Sử dụng SiteController để render view
            $siteController = new SiteController();
            $content = $siteController->renderView('profile.php', ['userData' => $userData]);
            $siteController->renderLayout($content);
        } else {
            echo "Bạn cần đăng nhập để xem hồ sơ.";
        }
    }
}

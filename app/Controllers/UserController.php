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
            require_once __DIR__ . '/../Views/User/login.php';  // Hiển thị form login
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
                header('Location: /user/list');
            } else {
                echo "Error creating user!";
            }
        }

        require_once __DIR__ . '/../Views/User/create_user.php';
    }

    public function listUsers()
    {
        $users = $this->userModel->getAllUsers();
        require_once __DIR__ . '/../Views/User/list_users.php';
    }

    public function deleteUser($id = null)
    {
        // Kiểm tra xem ID có tồn tại không
        if ($id === null) {
            echo "ID không tồn tại.";
            return;
        }

        // Gọi model để xóa người dùng
        if ($this->userModel->deleteUser($id)) {
            header("Location: /user/list");
            exit; // Kết thúc xử lý sau khi chuyển hướng
        } else {
            echo "Xóa người dùng thất bại.";
        }
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

    public function editUser($id)
    {
        // Kiểm tra nếu người dùng submit form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $role = $_POST['role'];

            // Gọi hàm cập nhật người dùng
            if ($this->userModel->updateUser($id, $username, $full_name, $email, $role)) {
                header('Location: /user/list');
            } else {
                echo "Cập nhật thất bại!";
            }
        } else {
            // Lấy thông tin người dùng cần chỉnh sửa
            $user = $this->userModel->getUserById($id);
            require_once __DIR__ . '/../Views/User/edit_user.php';
        }
    }
}

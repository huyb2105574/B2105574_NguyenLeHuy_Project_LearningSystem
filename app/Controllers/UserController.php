<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\User;

use App\Models\Registration;

class UserController
{

    private $db;
    private $userModel;
    private $registrationModel;
    public function __construct()
    {
        // Kết nối với cơ sở dữ liệu
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userModel = new User($this->db);
        $this->registrationModel = new Registration($this->db);
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
                    'phone_number' => $user['phone_number'],
                    'address' => $user['address'],
                    'date_of_birth' => $user['date_of_birth'],
                    'role' => $user['role']
                ];
                echo json_encode(['status' => 'success', 'message' => 'Đăng nhập thành công!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập hoặc mật khẩu không chính xác!']);
            }
            exit();
            header('Location:/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            require_once __DIR__ . '/../Views/User/login.php';
        }
    }


    public function createUser()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo "Access denied!";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $address = $_POST['address'];
            $date_of_birth = $_POST['date_of_birth'];
            $role = $_POST['role'];

            if ($this->userModel->createUser($username, $password, $full_name, $email, $role, $phone_number, $address, $date_of_birth)) {
                header('Location: /user/list');
            } else {
                echo "Error creating user!";
            }
        }

        $userData = $this->getUserData();
        $content = $this->renderView('User/create_user.php', ['userData' => $userData]);
        $this->renderLayout($content, $userData);
    }

    public function createUserWithRegistration($registrationId = null)
    {
        // Kiểm tra quyền truy cập
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo "Access denied!";
            return;
        }

        // Lấy thông tin từ đơn đăng ký nếu có registrationId
        $registrationData = null;
        if ($registrationId !== null) {
            $registrationData = $this->registrationModel->getRegistrationById($registrationId);
            if (!$registrationData) {
                echo "Đơn đăng ký không tồn tại!";
                return;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $address = $_POST['address'];
            $date_of_birth = $_POST['date_of_birth'];
            $role = $_POST['role'];
            if ($this->userModel->createUser($username, $password, $full_name, $email, $role, $phone_number, $address, $date_of_birth, $registrationId)) {
                $this->registrationModel->approveRegistration($registrationId);
                header('Location: /user/list');
            } else {
                echo "Error creating user!";
            }
        } else {
            $userData = $this->getUserData();
            $content = $this->renderView('User/create_user.php', ['userData' => $userData,  'registrationData' => $registrationData]);
            $this->renderLayout($content, $userData);
        }
    }


    public function listUsers()
    {
        $users = $this->userModel->getAllUsers();
        $registrations = $this->registrationModel->getAllRegistrations();
        $userData = $this->getUserData();
        $content = $this->renderView('User/list_users.php', ['userData' => $userData, 'users' => $users, 'registrations' => $registrations]);
        $this->renderLayout($content, $userData);
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

    public function editUser($id)
    {
        // Kiểm tra nếu người dùng submit form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $address = $_POST['address'];
            $date_of_birth = $_POST['date_of_birth'];
            $role = $_POST['role'];

            // Gọi hàm cập nhật người dùng
            if ($this->userModel->updateUser($id, $username, $full_name, $email, $role, $phone_number, $address, $date_of_birth)) {
                header('Location: /user/list');
            } else {
                echo "Cập nhật thất bại!";
            }
        } else {
            // Lấy thông tin người dùng cần chỉnh sửa
            $user = $this->userModel->getUserById($id);
            $userData = $this->getUserData();
            $content = $this->renderView('User/edit_user.php', ['userData' => $userData, 'user' => $user]);
            $this->renderLayout($content, $userData);
        }
    }

    public function changePassword($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];
            $userId = $id;

            // Kiểm tra sự khớp của mật khẩu xác nhận
            if ($newPassword !== $confirmPassword) {
                $_SESSION['error_message'] = 'Mật khẩu xác nhận không khớp.';
                header('Location: /profile');
                exit();
            }

            // Lấy thông tin người dùng từ cơ sở dữ liệu
            $user = $this->userModel->getUserById($userId);
            // Kiểm tra mật khẩu hiện tại
            if (password_verify($currentPassword, $user['password'])) {
                // Mã hóa và cập nhật mật khẩu mới
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->userModel->updatePassword($userId, $hashedPassword);
                $_SESSION['success_message'] = 'Đổi mật khẩu thành công.';
            } else {
                $_SESSION['error_message'] = 'Mật khẩu hiện tại không đúng.';
            }

            // Chuyển hướng về trang profile
            header('Location: /profile');
            exit();
        }
    }

    public function updateInfo($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $id;
            $full_name = $_POST['full_name'];
            $email = $_POST['email'];
            $phone_number = $_POST['phone_number'];
            $address = $_POST['address'];
            $date_of_birth = $_POST['date_of_birth'];

            $isUpdated = $this->userModel->updateUserInfo($id, $full_name, $email, $phone_number, $address, $date_of_birth);

            if ($isUpdated) {
                $_SESSION['success_message'] = 'Cập nhật thông tin thành công.';
            } else {
                $_SESSION['error_message'] = 'Cập nhật thông tin thất bại.';
            }
            header('Location: /profile');
            exit();
        }
    }



    public function getUserData()
    {
        return $_SESSION['user'] ?? null;
    }
    public function renderView($view, $data = [])
    {
        // Tạo biến $data cho view
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

<?php

namespace App\Controllers;

use App\Config\Database;
use App\Models\User;
use App\Services\MailService;
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
                    'password' => $user['password'],
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

    private function generateUniqueUsername($role)
    {

        $existingUsernames = $this->userModel->getAllUsernamesByRole($role);


        $prefix = strtolower($role);
        $number = 1;
        $username = $prefix . $number;


        while (in_array($username, $existingUsernames)) {
            $number++;
            $username = $prefix . $number;
        }

        return $username;
    }


    public function createUserWithRegistration($registrationId = null)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo "Access denied!";
            return;
        }

        $registrationData = null;
        if ($registrationId !== null) {
            $registrationData = $this->registrationModel->getRegistrationById($registrationId);
            if (!$registrationData) {
                echo "Đơn đăng ký không tồn tại!";
                return;
            }
        }

        $role = $registrationData['role'];
        $username = $this->generateUniqueUsername($role);
        $password = '123';

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

                // Gửi email
                $mailService = new MailService();
                $subject = "Account Created";
                $body = "
                    <h1>Xin chào, {$full_name}</h1>
                    <p>Tài khoản của bạn đã được tạo thành công trên hệ thống.</p>
                    <p><strong>Tên đăng nhập:</strong> {$username}</p>
                    <p><strong>Mật khẩu:</strong> 123 (vui lòng đổi mật khẩu sau khi đăng nhập)</p>
                    <p><a href='http://localhost:8000/login'>Đăng nhập ngay</a></p>
                ";
                $mailService->sendEmail($email, $subject, $body);

                header('Location: /user/list');
            } else {
                echo "Error creating user!";
                header('Location: /user/list');
            }
        } else {
            $userData = $this->getUserData();
            $content = $this->renderView('User/create_user.php', ['userData' => $userData,  'registrationData' => $registrationData, 'username' => $username, 'password' => $password]);
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
        if ($id === null) {
            $_SESSION['error'] = "ID không tồn tại.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        if ($this->userModel->deleteUser($id)) {
            header("Location: /user/list");
            exit;
        } else {
            $_SESSION['error'] = "Xóa người dùng thất bại.";
            header("Location: " . $_SERVER['HTTP_REFERER']);
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

            if ($this->userModel->updateUser($id, $username, $full_name, $email, $role, $phone_number, $address, $date_of_birth)) {
                header('Location: /user/list');
            } else {
                $_SESSION['error'] = "Cập nhật thất bại!";
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
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

    public function changePasswordFirstTime($id)
    {
        $user = $this->userModel->getUserById($id);

        if ($user && password_verify('123', $user['password'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $newPassword = $_POST['new_password'];
                $confirmPassword = $_POST['confirm_password'];
                if ($newPassword !== $confirmPassword) {
                    $_SESSION['error_message'] = 'Mật khẩu xác nhận không khớp.';
                    header('Location: /change_password_first_time/' . $id);
                    exit();
                }
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $this->userModel->updatePassword($id, $hashedPassword);
                $_SESSION['success_message'] = 'Đổi mật khẩu thành công.';
                header('Location: /home');
                exit();
            }


            $userData = $this->getUserData();
            $content = $this->renderView('User/change_password_first_time.php', ['userData' => $userData]);
            $this->renderLayout($content, $userData);
        } else {
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

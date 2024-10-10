<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\User;

class SiteController
{
    private $courseModel;
    private $userModel;

    public function __construct()
    {
        $this->courseModel = new Course($this->getDatabaseConnection());
        $this->userModel = new User($this->getDatabaseConnection());
    }


    private function getDatabaseConnection()
    {
        $database = new \App\Config\Database();
        return $database->getConnection();
    }

    public function home()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }
        $userData = $this->getUserData();
        $courses = $this->courseModel->getAllCourses();
        $lecturers = $this->userModel->getAllLecturers();

        // Trả về view
        $content = $this->renderView('home.php', [
            'userData' => $userData,
            'courses' => $courses,
            'lecturers' => $lecturers
        ]);
        $this->renderLayout($content, $userData);
    }

    public function courses()
    {
        $userData = $this->getUserData();
        $courses = $this->courseModel->getAllCourses();
        $content = $this->renderView('Course/courses.php', ['courses' => $courses, 'userData' => $userData]);
        $this->renderLayout($content, $userData);
    }

    public function profile()
    {
        if (!isset($_SESSION['user'])) {
            echo "Bạn cần đăng nhập để xem hồ sơ.";
            return;
        }
        $userData = $this->getUserData();
        $content = $this->renderView('User/profile.php', ['userData' => $userData]);
        $this->renderLayout($content, $userData);
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

<?php

namespace App\Controllers;

use App\Models\Course;

class SiteController
{
    private $courseModel;

    public function __construct()
    {
        $this->courseModel = new Course($this->getDatabaseConnection());
    }


    private function getDatabaseConnection()
    {
        $database = new \App\Config\Database();
        return $database->getConnection();
    }

    public function home()
    {
        $userData = $this->getUserData();
        $content = $this->renderView('home.php', ['userData' => $userData]);
        $this->renderLayout($content, $userData); // Truyền $userData
    }

    public function courses()
    {
        $userData = $this->getUserData();
        $courses = $this->courseModel->getAllCourses();
        $content = $this->renderView('courses.php', ['courses' => $courses, 'userData' => $userData]);
        $this->renderLayout($content, $userData); // Truyền $userData
    }

    public function profile()
    {
        if (!isset($_SESSION['user'])) {
            echo "Bạn cần đăng nhập để xem hồ sơ.";
            return;
        }
        $userData = $this->getUserData();
        $content = $this->renderView('profile.php', ['userData' => $userData]);
        $this->renderLayout($content, $userData); // Truyền $userData
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

        // Truyền biến $userData cho layout
        include $layoutPath;
    }
}

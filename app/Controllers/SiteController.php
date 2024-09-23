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
        $content = $this->renderView('home.php');
        $this->renderLayout($content);
    }

    public function courses()
    {
        $courses = $this->courseModel->getAllCourses();
        $content = $this->renderView('courses.php', ['courses' => $courses]);
        $this->renderLayout($content);
    }

    public function profile()
    {
        $content = $this->renderView('profile.php');
        $this->renderLayout($content);
    }

    private function renderView($view, $data = [])
    {
        // Tạo biến $data cho view
        extract($data);

        ob_start();
        include __DIR__ . "/../Views/$view";
        return ob_get_clean();
    }

    private function renderLayout($content)
    {
        $layoutPath = __DIR__ . '/../Views/layout.php';
        
        if (file_exists($layoutPath)) {
            include $layoutPath;
        } else {
            echo "Layout file not found!";
        }
    }
}

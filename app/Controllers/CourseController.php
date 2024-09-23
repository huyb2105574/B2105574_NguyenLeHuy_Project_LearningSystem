<?php

namespace App\Controllers;

use App\Models\Course;
use App\Config\Database;
class CourseController
{

    private $db;
    private $courseModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->courseModel = new Course($this->db);
    }


    

    public function create()
    {
        // Kiểm tra vai trò người dùng
        if ($_SESSION['role'] !== 'admin') {
            // Nếu không phải Admin, hiển thị thông báo lỗi hoặc chuyển hướng
            echo "Bạn không có quyền truy cập trang này.";
            return;
        }

        // Nếu là Admin, hiển thị trang tạo khóa học
        $content = $this->renderView('create_course.php');
        $this->renderLayout($content);
    }

    public function store()
    {
        // Kiểm tra vai trò người dùng
        if ($_SESSION['role'] !== 'admin') {
            // Nếu không phải Admin, ngăn chặn lưu khóa học
            echo "Bạn không có quyền thực hiện hành động này.";
            return;
        }

        // Xử lý lưu khóa học mới nếu là Admin
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseName = $_POST['course_name'];
            $description = $_POST['description'];
            $lecturerId = $_POST['lecturer_id'];
            $startDate = $_POST['start_date'];
            $endDate = $_POST['end_date'];

            if ($this->courseModel->createCourse($courseName, $description, $lecturerId, $startDate, $endDate)) {
                echo "Course created successfully!";
            } else {
                echo "Error creating course!";
            }

            // Điều hướng về trang danh sách khóa học
            header('Location: /courses');
            exit();
        }
    }

    private function renderView($view)
    {
        ob_start();
        include __DIR__ . '/../Views/' . $view;
        return ob_get_clean();
    }

    private function renderLayout($content)
    {
        include __DIR__ . '/../Views/layout.php';
    }
}

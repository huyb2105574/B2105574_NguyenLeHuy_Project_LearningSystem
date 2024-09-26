<?php

namespace App\Controllers;

use App\Models\Course;
use App\Config\Database;

class CourseController
{

    private $db;
    private $courseModel;

    public function __construct()
    {
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

            // Xử lý upload hình ảnh
            $targetDir = "src/uploads/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Kiểm tra xem tệp có phải là hình ảnh không
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "Tệp không phải là hình ảnh.";
                $uploadOk = 0;
            }

            // Kiểm tra xem tệp có tồn tại không
            if (file_exists($targetFile)) {
                echo "Xin lỗi, tệp đã tồn tại.";
                $uploadOk = 0;
            }

            // Giới hạn loại tệp ảnh được tải lên (chỉ jpg, png, jpeg, gif)
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                echo "Chỉ các tệp JPG, JPEG, PNG & GIF được cho phép.";
                $uploadOk = 0;
            }

            // Kiểm tra có lỗi xảy ra khi tải ảnh
            if ($uploadOk == 0) {
                echo "Xin lỗi, tệp của bạn không được tải lên.";
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    $imagePath = $targetFile;
                } else {
                    echo "Xin lỗi, đã có lỗi khi tải tệp của bạn.";
                    $imagePath = null; // Trong trường hợp không có ảnh
                }
            }

            // Gọi model để lưu khóa học vào database
            if ($this->courseModel->createCourse($courseName, $description, $lecturerId, $startDate, $endDate, $imagePath)) {
                echo "Khóa học đã được tạo thành công!";
            } else {
                echo "Có lỗi khi tạo khóa học!";
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

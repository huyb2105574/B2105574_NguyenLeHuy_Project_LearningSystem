<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\Lecture;
use App\Config\Database;

class CourseController
{
    private $db;
    private $courseModel;
    private $lectureModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->courseModel = new Course($this->db);
        $this->lectureModel = new Lecture($this->db);
    }

    // Hiển thị form tạo khóa học
    public function create()
    {
        $userData = $_SESSION['user'] ?? null;
        if (!$userData || $userData['role'] !== 'admin') {
            echo "Bạn không có quyền truy cập trang này.";
            return;
        }

        // Nếu là Admin, hiển thị trang tạo khóa học
        $content = $this->renderView('create_course.php');
        $this->renderLayout($content);
    }

    // Lưu khóa học mới
    public function store()
    {
        $userData = $_SESSION['user'] ?? null;
        if ($userData['role'] !== 'admin') {
            echo "Bạn không có quyền thực hiện hành động này.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseName = $_POST['course_name'];
            $description = $_POST['description'];
            $lecturerId = $_POST['lecturer_id'];
            $startDate = $_POST['start_date'];
            $endDate = $_POST['end_date'];

            // Xử lý upload hình ảnh
            $targetDir = __DIR__ . '/../../public/uploads/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true); // Tạo thư mục nếu chưa tồn tại
            }

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

            // Giới hạn loại tệp được phép tải lên
            if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                echo "Chỉ các tệp JPG, JPEG, PNG & GIF được cho phép.";
                $uploadOk = 0;
            }

            // Kiểm tra có lỗi trong quá trình tải ảnh không
            if ($uploadOk === 0) {
                echo "Xin lỗi, tệp của bạn không được tải lên.";
            } else {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    $imagePath = basename($_FILES["image"]["name"]); // Lưu tên tệp
                } else {
                    echo "Xin lỗi, đã có lỗi khi tải tệp của bạn.";
                    $imagePath = null;
                }
            }

            // Lưu khóa học
            if ($this->courseModel->createCourse($courseName, $description, $lecturerId, $startDate, $endDate, $imagePath)) {
                echo "Khóa học đã được tạo thành công!";
            } else {
                echo "Có lỗi khi tạo khóa học!";
            }

            header('Location: /courses');
            exit();
        }
    }

    // Hiển thị form chỉnh sửa khóa học
    public function edit($course_id)
    {
        // Lấy thông tin khóa học
        $course = $this->courseModel->getCourseById($course_id);

        if (!$course) {
            die('Khóa học không tồn tại.');
        }

        // Trả về view để hiển thị form chỉnh sửa
        $content = $this->renderView('edit_course.php', ['course' => $course]);
        $this->renderLayout($content);
    }

    // Cập nhật khóa học
    public function update($course_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseData = [
                'course_name' => $_POST['course_name'],
                'description' => $_POST['description'],
                'lecturer_id' => $_POST['lecturer_id'],
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
            ];

            // Kiểm tra xem có upload ảnh mới không
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image_name = time() . '_' . $_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], '../src/uploads/' . $image_name);
                $courseData['image_path'] = $image_name; // Thêm đường dẫn ảnh vào mảng
            }

            // Cập nhật khóa học
            $this->courseModel->updateCourse($course_id, $courseData);
            header('Location: /courses');
            exit();
        }
    }


    // Xóa khóa học
    public function delete($course_id)
    {
        $this->courseModel->deleteCourse($course_id);
        header('Location: /courses');
        exit;
    }

    public function show($course_id)
    {
        // Lấy thông tin khóa học theo ID
        $course = $this->courseModel->getCourseById($course_id);
        $lectures = $this->lectureModel->getAllLecturesByCourse($course_id);
        // Kiểm tra nếu khóa học không tồn tại
        if (!$course) {
            die('Khóa học không tồn tại.');
        }

        // Trả về view hiển thị chi tiết khóa học
        $content = $this->renderView('course_detail.php', ['course' => $course, 'lectures' => $lectures]);
        $this->renderLayout($content);
    }
    // Render view
    private function renderView($view, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../Views/' . $view;
        return ob_get_clean();
    }

    // Render layout
    private function renderLayout($content)
    {
        include __DIR__ . '/../Views/layout.php';
    }
}
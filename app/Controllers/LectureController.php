<?php

namespace App\Controllers;

use App\Models\Lecture;
use App\Config\Database;

class LectureController
{
    private $db;
    private $lectureModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->lectureModel = new Lecture($this->db);
    }

    public function showAllLectures($courseId)
    {
        $lectures = $this->lectureModel->getAllLecturesByCourse($courseId);
    }

    public function addLecture($courseId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $filePath = '';

            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $targetDirectory = __DIR__ . '/../../public/uploads/';

                // Tạo thư mục nếu chưa có
                if (!is_dir($targetDirectory)) {
                    mkdir($targetDirectory, 0777, true);
                }

                $fileName = basename($_FILES['file']['name']);
                $filePath = $fileName;

                // Kiểm tra kích thước file
                if ($_FILES['file']['size'] > 5000000) {
                    echo "File quá lớn.";
                    return;
                }

                // Di chuyển file
                if (move_uploaded_file($_FILES['file']['tmp_name'], $targetDirectory . $fileName)) {
                    echo "Tải file lên thành công!";
                } else {
                    echo "Có lỗi khi tải lên tệp.";
                    return;
                }
            }

            // Thêm bài giảng vào cơ sở dữ liệu
            $this->lectureModel->addLecture($courseId, $title, $content, $filePath);
            header("Location: /courses/show/$courseId");
            exit();
        }

        include __DIR__ . '/../Views/Lecture/add_lecture.php';
    }



    public function editLecture($lectureId)
    {
        $lecture = $this->lectureModel->getLectureById($lectureId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $filePath = '';
            $this->lectureModel->updateLecture($lectureId, $title, $content, $filePath);
            header("Location: /courses/show/" . $lecture['course_id']);
        }
        include __DIR__ . '/../Views/Lecture/edit_lecture.php';
    }

    public function deleteLecture($lectureId)
    {
        $lecture = $this->lectureModel->getLectureById($lectureId);
        $this->lectureModel->deleteLecture($lectureId);
        header("Location: /courses/show/" . $lecture['course_id']);
    }
    public function showLecture($lectureId)
    {
        $lecture = $this->lectureModel->getLectureById($lectureId);

        if ($lecture) {
            require __DIR__ . '/../Views/Lecture/show_lecture.php';
        } else {
            echo "Bài giảng không tồn tại.";
        }
    }
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

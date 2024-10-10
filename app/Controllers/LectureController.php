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
        $userData = $this->getUserData();
        $content = $this->renderView('Lecture/add_lecture.php', ['userData' => $userData, 'courseId' => $courseId]);
        $this->renderLayout($content, $userData);
    }



    public function editLecture($lectureId)
    {
        // Lấy thông tin bài giảng hiện tại từ cơ sở dữ liệu
        $lecture = $this->lectureModel->getLectureById($lectureId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $filePath = $lecture['file_path'];

            // Xử lý file mới nếu có
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                $targetDirectory = __DIR__ . '/../../public/uploads/';

                if (!is_dir($targetDirectory)) {
                    mkdir($targetDirectory, 0777, true);
                }

                $fileName = basename($_FILES['file']['name']);
                $filePath = $fileName;
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

            // Cập nhật bài giảng vào cơ sở dữ liệu
            $this->lectureModel->updateLecture($lectureId, $title, $content, $filePath);
            header("Location: /courses/show/" . $lecture['course_id']);
            exit();
        }

        $userData = $this->getUserData();
        $content = $this->renderView('Lecture/edit_lecture.php', ['userData' => $userData, 'lecture' => $lecture]);
        $this->renderLayout($content, $userData);
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
            $userData = $this->getUserData();
            $content = $this->renderView('Lecture/show_lecture.php', ['userData' => $userData, 'lecture' => $lecture]);
            $this->renderLayout($content, $userData);
        } else {
            echo "Bài giảng không tồn tại.";
        }
    }
    public function getUserData()
    {
        return $_SESSION['user'] ?? null;
    }
    private function renderView($view, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . '/../Views/' . $view;
        return ob_get_clean();
    }

    public function renderLayout($content, $userData = [])
    {
        $layoutPath = __DIR__ . '/../Views/layout.php';
        include $layoutPath;
    }
}

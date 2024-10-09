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
        if ($lectures) {
            // Hiển thị danh sách bài giảng
            include __DIR__ . '../Views/lectures.php'; // Tệp view cho danh sách bài giảng
        } else {
            echo "Không có bài giảng nào cho khóa học này.";
        }
    }

    public function addLecture($courseId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input data and process file upload
            $title = $_POST['title'];
            $content = $_POST['content'];
            $filePath = ''; // Handle file upload and set the path

            // Insert lecture into the database
            $this->lectureModel->addLecture($courseId, $title, $content, $filePath);
            header("Location: /courses/show/$courseId");
        }
        // Render add lecture form
        require 'Views/add_lecture.php';
    }

    public function editLecture($lectureId)
    {
        // Fetch lecture details
        $lecture = $this->lectureModel->getLectureById($lectureId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input data and process file upload
            $title = $_POST['title'];
            $content = $_POST['content'];
            $filePath = ''; // Handle file upload if necessary

            // Update lecture in the database
            $this->lectureModel->updateLecture($lectureId, $title, $content, $filePath);
            header("Location: /courses/show/" . $lecture['course_id']);
        }
        // Render edit lecture form
        require 'Views/edit_lecture.php';
    }

    public function deleteLecture($lectureId)
    {
        $lecture = $this->lectureModel->getLectureById($lectureId);
        $this->lectureModel->deleteLecture($lectureId);
        header("Location: /courses/show/" . $lecture['course_id']);
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
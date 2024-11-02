<?php

namespace App\Controllers;

use App\Models\Assignment;
use App\Config\Database;
use App\Models\Submission;

class AssignmentController
{
    private $db;
    private $assignmentModel;
    private $submissionModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->assignmentModel = new Assignment($this->db);
        $this->submissionModel = new Submission($this->db);
    }

    // Hiển thị danh sách bài tập của khóa học
    public function showAllAssignments($courseId)
    {
        $assignments = $this->assignmentModel->getAllAssignmentsByCourse($courseId);
        $userData = $this->getUserData();
        $content = $this->renderView('Assignment/list_assignments.php', ['userData' => $userData, 'assignments' => $assignments, 'courseId' => $courseId]);
        $this->renderLayout($content, $userData);
    }

    // Thêm bài tập
    public function addAssignment($courseId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $dueDate = $_POST['due_date'];

            // Thêm bài tập vào cơ sở dữ liệu
            $this->assignmentModel->addAssignment($courseId, $title, $description, $dueDate);
            header("Location: /courses/show/$courseId");
            exit();
        }
        $userData = $this->getUserData();
        $content = $this->renderView('Assignment/add_assignment.php', ['userData' => $userData, 'courseId' => $courseId]);
        $this->renderLayout($content, $userData);
    }

    // Sửa bài tập
    public function editAssignment($assignmentId)
    {
        $assignment = $this->assignmentModel->getAssignmentById($assignmentId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $dueDate = $_POST['due_date'];

            // Cập nhật bài tập
            $this->assignmentModel->updateAssignment($assignmentId, $title, $description, $dueDate);
            header("Location: /courses/show/" . $assignment['course_id']);
            exit();
        }
        $userData = $this->getUserData();
        $content = $this->renderView('Assignment/edit_assignment.php', ['userData' => $userData, 'assignment' => $assignment]);
        $this->renderLayout($content, $userData);
    }

    // Xóa bài tập
    public function deleteAssignment($assignmentId)
    {
        $assignment = $this->assignmentModel->getAssignmentById($assignmentId);
        $this->assignmentModel->deleteAssignment($assignmentId);
        header("Location: /courses/show/" . $assignment['course_id']);
    }

    public function showAssignment($assignmentId)
    {
        $assignment = $this->assignmentModel->getAssignmentById($assignmentId);
        $userData = $this->getUserData();
        $submission = $this->submissionModel->getSubmissionByAssignmentAndUser($assignmentId, $userData['user_id']);
        if ($assignment) {
            $content = $this->renderView('Assignment/show_assignment.php', ['userData' => $userData, 'assignment' => $assignment, "submission" => $submission]);
            $this->renderLayout($content, $userData);
        } else {
            echo "Bài tập không tồn tại";
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
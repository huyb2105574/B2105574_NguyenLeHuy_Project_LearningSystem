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

    public function addAssignment($courseId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $dueDate = $_POST['due_date'];
            $filePath = null;
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['file']['tmp_name'];
                $fileName = $_FILES['file']['name'];
                $filePath = 'uploads/' . basename($fileName);
                move_uploaded_file($fileTmpPath, $filePath);
            }
            $this->assignmentModel->addAssignment($courseId, $title, $description, $dueDate, $filePath);
            header("Location: /courses/show/$courseId");
            exit();
        }
        $userData = $this->getUserData();
        $content = $this->renderView('Assignment/add_assignment.php', ['userData' => $userData, 'courseId' => $courseId]);
        $this->renderLayout($content, $userData);
    }


    public function editAssignment($assignmentId)
    {
        $assignment = $this->assignmentModel->getAssignmentById($assignmentId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $dueDate = $_POST['due_date'];

            $filePath = $assignment['file_path'];
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['file']['tmp_name'];
                $fileName = $_FILES['file']['name'];
                $filePath = 'uploads/' . basename($fileName);
                move_uploaded_file($fileTmpPath, $filePath);
            }


            $this->assignmentModel->updateAssignment($assignmentId, $title, $description, $dueDate, $filePath);
            header("Location: /courses/show/" . $assignment['course_id']);
            exit();
        }
        $userData = $this->getUserData();
        $content = $this->renderView('Assignment/edit_assignment.php', ['userData' => $userData, 'assignment' => $assignment]);
        $this->renderLayout($content, $userData);
    }

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
        $submissions = $this->submissionModel->getAllSubmissionsByAssignment($assignmentId);

        if ($assignment) {
            $content = $this->renderView('Assignment/show_assignment.php', [
                'userData' => $userData,
                'assignment' => $assignment,
                'submission' => $submission,
                'submissions' => $submissions
            ]);
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

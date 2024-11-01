<?php

namespace App\Controllers;

use App\Models\Submission;
use App\Config\Database;

class SubmissionController
{
    private $db;
    private $submissionModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->submissionModel = new Submission($this->db);
    }

    // Nộp bài tập
    public function submitAssignment($assignmentId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $studentId = $_SESSION['user']['user_id'];
            $filePath = $this->uploadFile($_FILES['file']);

            if ($filePath) {
                $this->submissionModel->addSubmission($assignmentId, $studentId, $filePath);
                header("Location: /assignment/show/$assignmentId");
                exit();
            } else {
                echo "Đã xảy ra lỗi khi tải lên tệp.";
            }
        }

        $userData = $this->getUserData();
        $content = $this->renderView('Submission/submit_assignment.php', ['userData' => $userData, 'assignmentId' => $assignmentId]);
        $this->renderLayout($content, $userData);
    }


    // Sửa bài nộp
    public function editSubmission($submissionId)
    {
        $submission = $this->submissionModel->getSubmissionById($submissionId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            $filePath = $this->uploadFile($_FILES['file']);
            if ($filePath) {
                $this->submissionModel->updateSubmission($submissionId, $filePath);
                header("Location: /assignment/show/" . $submission['assignment_id']);
                exit();
            } else {
                echo "Đã xảy ra lỗi khi tải lên tệp.";
            }
        }

        $userData = $this->getUserData();
        $content = $this->renderView('Submission/edit_submission.php', ['userData' => $userData, 'submission' => $submission]);
        $this->renderLayout($content, $userData);
    }

    // Xóa bài nộp
    public function deleteSubmission($submissionId)
    {
        $submission = $this->submissionModel->getSubmissionById($submissionId);
        $this->submissionModel->deleteSubmission($submissionId);
        header("Location: /assignment/show/" . $submission['assignment_id']);
        exit();
    }

    private function uploadFile($file)
    {

        $targetDir = __DIR__ . "/../../public/uploads/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($file["name"]);
        $filePath = $targetDir . $fileName;

        if (move_uploaded_file($file["tmp_name"], $filePath)) {
            return "/uploads/" . $fileName;
        } else {
            return false;
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

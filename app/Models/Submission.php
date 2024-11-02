<?php

namespace App\Models;

use PDO;

class Submission
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addSubmission($assignmentId, $studentId, $filePath)
    {
        $query = "INSERT INTO submissions (assignment_id, student_id, file_path) VALUES (:assignment_id, :student_id, :file_path)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':assignment_id', $assignmentId);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->bindParam(':file_path', $filePath);
        return $stmt->execute();
    }

    public function getSubmissionById($submissionId)
    {
        $query = "SELECT * FROM submissions WHERE submission_id = :submission_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':submission_id', $submissionId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateSubmission($submissionId, $filePath)
    {
        $query = "UPDATE submissions SET file_path = :file_path, submitted_at = NOW() WHERE submission_id = :submission_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':file_path', $filePath);
        $stmt->bindParam(':submission_id', $submissionId);
        return $stmt->execute();
    }

    public function deleteSubmission($submissionId)
    {
        $query = "DELETE FROM submissions WHERE submission_id = :submission_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':submission_id', $submissionId);
        return $stmt->execute();
    }

    public function getSubmissionByAssignmentAndUser($assignmentId, $studentId)
    {
        $query = "SELECT * FROM submissions WHERE assignment_id = :assignment_id AND student_id = :student_id LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':assignment_id', $assignmentId);
        $stmt->bindParam(':student_id', $studentId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllSubmissionsByAssignment($assignmentId)
    {
        $stmt = $this->db->prepare("
            SELECT submissions.*, users.full_name
            FROM submissions
            JOIN users ON submissions.student_id = users.user_id
            WHERE submissions.assignment_id = ?
        ");
        $stmt->execute([$assignmentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

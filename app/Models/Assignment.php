<?php

namespace App\Models;

use PDO;

class Assignment
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllAssignmentsByCourse($courseId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM assignments WHERE course_id = ?");
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAssignment($courseId, $title, $description, $dueDate)
    {
        $stmt = $this->conn->prepare("INSERT INTO assignments (course_id, title, description, due_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$courseId, $title, $description, $dueDate]);
    }

    public function getAssignmentById($assignmentId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM assignments WHERE assignment_id = ?");
        $stmt->execute([$assignmentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAssignment($assignmentId, $title, $description, $dueDate)
    {
        $stmt = $this->conn->prepare("UPDATE assignments SET title = ?, description = ?, due_date = ? WHERE assignment_id = ?");
        $stmt->execute([$title, $description, $dueDate, $assignmentId]);
    }

    public function deleteAssignment($assignmentId)
    {
        $stmt = $this->conn->prepare("DELETE FROM assignments WHERE assignment_id = ?");
        $stmt->execute([$assignmentId]);
    }
}

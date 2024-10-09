<?php

namespace App\Models;

use PDO;

class Lecture
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAllLecturesByCourse($courseId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM lectures WHERE course_id = ?");
        $stmt->execute([$courseId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getLectureById($lectureId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM lectures WHERE lecture_id = ?");
        $stmt->execute([$lectureId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addLecture($courseId, $title, $content, $filePath)
    {
        $stmt = $this->conn->prepare("INSERT INTO lectures (course_id, title, content, file_path) VALUES (?, ?, ?, ?)");
        $stmt->execute([$courseId, $title, $content, $filePath]);
    }

    public function updateLecture($lectureId, $title, $content, $filePath)
    {
        $stmt = $this->conn->prepare("UPDATE lectures SET title = ?, content = ?, file_path = ? WHERE lecture_id = ?");
        $stmt->execute([$title, $content, $filePath, $lectureId]);
    }

    public function deleteLecture($lectureId)
    {
        $stmt = $this->conn->prepare("DELETE FROM lectures WHERE lecture_id = ?");
        $stmt->execute([$lectureId]);
    }
}
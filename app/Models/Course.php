<?php

namespace App\Models;

use PDO;


class Course
{
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy tất cả các khóa học
    public function getAllCourses()
    {
        $query = "
            SELECT c.course_id, c.course_name, c.description, c.start_date, c.end_date, u.full_name as lecturer_name
            FROM courses c
            LEFT JOIN users u ON c.lecturer_id = u.user_id
            ";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (\Exception $e) {
            return []; // Hoặc return false nếu bạn muốn xử lý lỗi khác
        }
    }

    // Lấy khóa học theo ID
    public function getCourseById($courseId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Tạo khóa học mới
    public function createCourse($courseName, $description, $lecturerId, $startDate, $endDate)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO courses (course_name, description, lecturer_id, start_date, end_date) 
            VALUES (:course_name, :description, :lecturer_id, :start_date, :end_date)
        ");
        $stmt->bindParam(':course_name', $courseName);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':lecturer_id', $lecturerId);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);

        return $stmt->execute();
    }

    // Xóa khóa học theo ID
    public function deleteCourse($courseId)
    {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $courseId);
        return $stmt->execute();
    }
}

<?php

namespace App\Models;

use PDO;


class Course
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy tất cả các khóa học
    public function createCourse($course_name, $description, $lecturer_id, $start_date, $end_date, $image_path)
    {
        $query = "INSERT INTO courses (course_name, description, lecturer_id, start_date, end_date, image_path) 
                  VALUES (:course_name, :description, :lecturer_id, :start_date, :end_date, :image_path)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_name', $course_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':lecturer_id', $lecturer_id);
        $stmt->bindParam(
            ':start_date',
            $start_date
        );
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(
            ':image_path',
            $image_path
        );
        return $stmt->execute();
    }

    // Lấy danh sách khóa học
    public function getAllCourses()
    {
        $query = "SELECT courses.*, users.full_name AS lecturer_name 
              FROM courses 
              LEFT JOIN users ON courses.lecturer_id = users.user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy khóa học theo ID
    public function getCourseById($courseId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $courseId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Xóa khóa học theo ID
    public function deleteCourse($courseId)
    {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $courseId);
        return $stmt->execute();
    }
}

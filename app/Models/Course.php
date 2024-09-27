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

    public function updateCourse($course_id, $courseData)
    {
        $stmt = $this->conn->prepare("
        UPDATE courses
        SET course_name = :course_name, description = :description, 
            lecturer_id = :lecturer_id, start_date = :start_date, end_date = :end_date
        WHERE course_id = :course_id
    ");
        // Bind parameters
        $stmt->bindParam(':course_name', $courseData['course_name']);
        $stmt->bindParam(':description', $courseData['description']);
        $stmt->bindParam(':lecturer_id', $courseData['lecturer_id']); // Kiểm tra trường này có tồn tại trong $courseData
        $stmt->bindParam(':start_date', $courseData['start_date']);
        $stmt->bindParam(':end_date', $courseData['end_date']);
        $stmt->bindParam(':course_id', $course_id);

        return $stmt->execute();
    }
}
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

    public function getEnrollmentStatus($student_id, $course_id)
    {
        $query = "SELECT status FROM enrollments WHERE student_id = :student_id AND course_id = :course_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function isStudentEnrolled($course_id, $student_id)
    {
        $query = "SELECT * FROM enrollments WHERE course_id = :course_id AND student_id = :student_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();
        return $stmt->fetch() ? true : false;
    }

    public function enrollStudent($course_id, $student_id)
    {
        $query = "INSERT INTO enrollments (course_id, student_id, status) VALUES (:course_id, :student_id, 'pending')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':student_id', $student_id);
        return $stmt->execute();
    }

    public function approveEnrollment($enrollment_id)
    {
        $stmt = $this->conn->prepare("UPDATE enrollments SET status = 'approved' WHERE enrollment_id = :enrollment_id");
        $stmt->bindParam(':enrollment_id', $enrollment_id);
        return $stmt->execute();
    }

    public function rejectEnrollment($enrollment_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM enrollments WHERE enrollment_id = :enrollment_id");
        $stmt->bindParam(':enrollment_id', $enrollment_id);
        return $stmt->execute();
    }



    public function getStudentsByCourse($course_id)
    {
        $stmt = $this->conn->prepare("
        SELECT users.user_id, users.full_name, users.email,enrollments.status, enrollments.enrollment_id 
        FROM enrollments 
        JOIN users ON enrollments.student_id = users.user_id 
        WHERE enrollments.course_id = ?
    ");
        $stmt->execute([$course_id]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmtTotalAssignments = $this->conn->prepare("
        SELECT COUNT(*) as total 
        FROM assignments 
        WHERE course_id = ?
    ");
        $stmtTotalAssignments->execute([$course_id]);
        $totalAssignments = $stmtTotalAssignments->fetch(PDO::FETCH_ASSOC)['total'];
        foreach ($students as &$student) {
            $submittedAssignments = 0;

            if ($totalAssignments > 0) {
                $stmtSubmitted = $this->conn->prepare("
                SELECT COUNT(*) as submitted 
                FROM submissions 
                INNER JOIN assignments ON submissions.assignment_id = assignments.assignment_id 
                WHERE assignments.course_id = ? AND submissions.student_id = ?
            ");
                $stmtSubmitted->execute([$course_id, $student['user_id']]);
                $submittedAssignments = $stmtSubmitted->fetch(PDO::FETCH_ASSOC)['submitted'] ?? 0;
            }

            $student['progress'] = $totalAssignments > 0
                ? round(($submittedAssignments / $totalAssignments) * 100, 2)
                : 0;

            $student['statusstudy'] = ($submittedAssignments == $totalAssignments && $totalAssignments > 0)
                ? 'Hoàn thành'
                : 'Đang học';
        }

        return $students;
    }


    public function searchCourses($query)
    {
        $query = "%" . $query . "%";
        $stmt = $this->conn->prepare("SELECT course_id, course_name FROM courses WHERE course_name LIKE ?");
        $stmt->execute([$query]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php

namespace App\Models;

use PDO;

class User
{
    private $conn;
    private $table = 'users';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Lấy thông tin người dùng theo ID
    public function getUserById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin người dùng theo username
    public function getUserByUserName($username)
    {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE username = :username";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Tạo người dùng mới
    public function createUser($username, $password, $full_name, $email, $role)
    {
        $query = "INSERT INTO " . $this->table . " (username, password, full_name, email, role) VALUES (:username, :password, :full_name, :email, :role)";
        $stmt = $this->conn->prepare($query);

        // Mã hóa mật khẩu
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Bind dữ liệu
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

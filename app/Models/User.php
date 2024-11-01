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

    public function createUser($username, $password, $full_name, $email, $role, $phone_number, $address, $date_of_birth)
    {
        $query = "INSERT INTO " . $this->table . " (username, password, full_name, email, phone_number, address, date_of_birth, role) 
                VALUES (:username, :password, :full_name, :email, :phone_number, :address, :date_of_birth, :role)";
        $stmt = $this->conn->prepare($query);

        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':role', $role);

        return $stmt->execute();
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteUser($id)
    {
        $query = "DELETE FROM users WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            print_r($stmt->errorInfo());  // Hiển thị lỗi nếu có
            return false;
        }
    }

    public function updateUser($id, $username, $full_name, $email, $role, $phone_number, $address, $date_of_birth)
    {
        $query = "UPDATE " . $this->table . " 
              SET username = :username, full_name = :full_name, email = :email, role = :role, 
                  phone_number = :phone_number, address = :address, date_of_birth = :date_of_birth
              WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function getAllLecturers()
    {
        $query = "SELECT * FROM users WHERE role = 'lecturer'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

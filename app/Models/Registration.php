<?php

namespace App\Models;

use PDO;

class Registration
{
    private $conn;
    private $table = 'registrations';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getRegistrationById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE registration_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getAllRegistrations()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createRegistration($full_name, $email, $phone_number, $address, $date_of_birth, $role, $status = 'pending')
    {
        $query = "INSERT INTO " . $this->table . " (full_name, email, phone_number, address, date_of_birth, role, status)
                  VALUES (:full_name, :email, :phone_number, :address, :date_of_birth, :role, :status)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':date_of_birth', $date_of_birth);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }

    public function approveRegistration($registrationId)
    {
        // Câu lệnh SQL để cập nhật trạng thái
        $query = "UPDATE registrations 
              SET status = 'approved' 
              WHERE registration_id = :registration_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':registration_id', $registrationId);
        return $stmt->execute();
    }

    public function deleteRegistration($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE registration_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

<?php
namespace App\Models;

use App\Database;
use PDO;
use PDOException;

class User {
    private $db;
    private $table = 'users';

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function register($data) {
        try {
            // Hash password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // Insert user
            $query = "INSERT INTO {$this->table} (name, email, password, role, status) 
                      VALUES (:name, :email, :password, :role, :status)";
            $this->db->query($query, $data);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($email, $password) {
        try {
            // Get user by email
            $query = "SELECT * FROM {$this->table} WHERE email = :email LIMIT 1";
            $user = $this->db->query($query, ['email' => $email])->fetch();

            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserById($id) {
        try {
            $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
            return $this->db->query($query, ['id' => $id])->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateProfile($id, $data) {
        try {
            $query = "UPDATE {$this->table} SET name = :name, email = :email WHERE id = :id";
            return $this->db->query($query, array_merge($data, ['id' => $id]));
        } catch (PDOException $e) {
            return false;
        }
    }

    public function changePassword($id, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $query = "UPDATE {$this->table} SET password = :password WHERE id = :id";
            return $this->db->query($query, [
                'password' => $hashedPassword,
                'id' => $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
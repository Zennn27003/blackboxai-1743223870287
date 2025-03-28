<?php
namespace App\Models;

use App\Database;
use PDO;
use PDOException;

class Course {
    private $db;
    private $table = 'courses';

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            $query = "INSERT INTO {$this->table} (title, description, department_id, duration_hours, is_required) 
                      VALUES (:title, :description, :department_id, :duration_hours, :is_required)";
            return $this->db->query($query, $data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAll() {
        try {
            $query = "SELECT * FROM {$this->table}";
            return $this->db->query($query)->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getById($id) {
        try {
            $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
            return $this->db->query($query, ['id' => $id])->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data) {
        try {
            $query = "UPDATE {$this->table} SET title = :title, description = :description, 
                      department_id = :department_id, duration_hours = :duration_hours, 
                      is_required = :is_required WHERE id = :id";
            return $this->db->query($query, array_merge($data, ['id' => $id]));
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($id) {
        try {
            $query = "DELETE FROM {$this->table} WHERE id = :id";
            return $this->db->query($query, ['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
<?php
namespace App\Models;

use App\Database;
use PDO;
use PDOException;

class TrainingMaterial {
    private $db;
    private $table = 'training_materials';

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            $query = "INSERT INTO {$this->table} 
                     (course_id, name, file_path, file_type, file_size, uploaded_by) 
                     VALUES (:course_id, :name, :file_path, :file_type, :file_size, :uploaded_by)";
            return $this->db->query($query, $data);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getByCourse($courseId) {
        try {
            $query = "SELECT * FROM {$this->table} 
                     WHERE course_id = :course_id 
                     ORDER BY uploaded_at DESC";
            return $this->db->query($query, ['course_id' => $courseId])->fetchAll();
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

    public function delete($id) {
        try {
            $query = "DELETE FROM {$this->table} WHERE id = :id";
            return $this->db->query($query, ['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getRecentMaterials($limit = 5) {
        try {
            $query = "SELECT tm.*, c.title as course_title 
                     FROM {$this->table} tm
                     JOIN courses c ON tm.course_id = c.id
                     ORDER BY tm.uploaded_at DESC
                     LIMIT :limit";
            return $this->db->query($query, ['limit' => $limit])->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getMaterialsByTrainer($trainerId) {
        try {
            $query = "SELECT tm.*, c.title as course_title 
                     FROM {$this->table} tm
                     JOIN courses c ON tm.course_id = c.id
                     WHERE tm.uploaded_by = :trainer_id
                     ORDER BY tm.uploaded_at DESC";
            return $this->db->query($query, ['trainer_id' => $trainerId])->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }
}
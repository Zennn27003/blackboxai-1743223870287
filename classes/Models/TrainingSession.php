<?php
namespace App\Models;

use App\Database;
use PDO;
use PDOException;

class TrainingSession {
    private $db;
    private $table = 'training_sessions';

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            $query = "INSERT INTO {$this->table} (course_id, trainer_id, start_time, end_time, location, max_attendees) 
                      VALUES (:course_id, :trainer_id, :start_time, :end_time, :location, :max_attendees)";
            return $this->db->query($query, $data);
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

    public function getByTrainer($trainerId) {
        try {
            $query = "SELECT ts.*, c.title as course_title 
                      FROM {$this->table} ts
                      JOIN courses c ON ts.course_id = c.id
                      WHERE ts.trainer_id = :trainer_id
                      ORDER BY ts.start_time";
            return $this->db->query($query, ['trainer_id' => $trainerId])->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUpcomingSessions($limit = 5) {
        try {
            $query = "SELECT ts.*, c.title as course_title 
                      FROM {$this->table} ts
                      JOIN courses c ON ts.course_id = c.id
                      WHERE ts.start_time > NOW() 
                      AND ts.status = 'scheduled'
                      ORDER BY ts.start_time
                      LIMIT :limit";
            return $this->db->query($query, ['limit' => $limit])->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($id, $data) {
        try {
            $query = "UPDATE {$this->table} SET 
                      course_id = :course_id,
                      start_time = :start_time,
                      end_time = :end_time,
                      location = :location,
                      max_attendees = :max_attendees,
                      status = :status
                      WHERE id = :id";
            return $this->db->query($query, array_merge($data, ['id' => $id]));
        } catch (PDOException $e) {
            return false;
        }
    }

    public function cancel($id) {
        try {
            $query = "UPDATE {$this->table} SET status = 'cancelled' WHERE id = :id";
            return $this->db->query($query, ['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAttendees($sessionId) {
        try {
            $query = "SELECT u.id, u.name, u.email, a.status, a.notes
                      FROM attendance a
                      JOIN users u ON a.user_id = u.id
                      WHERE a.session_id = :session_id";
            return $this->db->query($query, ['session_id' => $sessionId])->fetchAll();
        } catch (PDOException $e) {
            return false;
        }
    }
}
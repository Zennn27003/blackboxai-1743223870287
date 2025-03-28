<?php
namespace App\Controllers;

use App\Database;
use App\Models\User;

class TrainerController {
    private $db;

    public function __construct(Database $db) {
        session_start();
        $this->db = $db;
        $this->checkTrainerAccess();
    }

    private function checkTrainerAccess() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'trainer') {
            header('Location: ' . URL_ROOT . '/home/login');
            exit();
        }
    }

    public function dashboard() {
        $data = [
            'title' => 'Trainer Dashboard',
            'upcoming_sessions' => $this->getUpcomingSessions()
        ];

        require_once 'views/trainer/dashboard.php';
    }

    public function sessions() {
        $data = [
            'title' => 'Training Sessions',
            'sessions' => $this->getAllSessions()
        ];

        require_once 'views/trainer/sessions.php';
    }

    public function materials() {
        $data = [
            'title' => 'Training Materials',
            'materials' => $this->getTrainingMaterials()
        ];

        require_once 'views/trainer/materials.php';
    }

    public function uploadMaterial() {
        require_once 'views/trainer/upload_material.php';
    }

    public function storeMaterial() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadResult = handleFileUpload($_FILES['file'], $_POST['course_id'], $_SESSION['user_id']);
            
            if ($uploadResult['success']) {
                $materialData = [
                    'course_id' => $_POST['course_id'],
                    'name' => $uploadResult['data']['name'],
                    'file_path' => $uploadResult['data']['file_path'],
                    'file_type' => $uploadResult['data']['file_type'],
                    'file_size' => $uploadResult['data']['file_size'],
                    'uploaded_by' => $_SESSION['user_id']
                ];
                
                $materialModel = new \App\Models\TrainingMaterial($this->db);
                if ($materialModel->create($materialData)) {
                    header('Location: ' . URL_ROOT . '/trainer/materials');
                    exit();
                } else {
                    // Handle database error
                    echo "Error saving material to database.";
                }
            } else {
                // Handle upload error
                echo "Error: " . $uploadResult['error'];
            }
        }
    }

    private function getUpcomingSessions() {
        // TODO: Implement actual database query
        return [
            ['id' => 1, 'title' => 'CPR Certification', 'date' => '2023-12-15', 'time' => '09:00'],
            ['id' => 2, 'title' => 'HIPAA Compliance', 'date' => '2023-12-18', 'time' => '13:00']
        ];
    }

    private function getAllSessions() {
        // TODO: Implement actual database query
        return [
            ['id' => 1, 'title' => 'CPR Certification', 'date' => '2023-12-15', 'status' => 'scheduled'],
            ['id' => 2, 'title' => 'HIPAA Compliance', 'date' => '2023-12-18', 'status' => 'scheduled'],
            ['id' => 3, 'title' => 'Infection Control', 'date' => '2023-12-05', 'status' => 'completed']
        ];
    }

    private function getTrainingMaterials() {
        $materialModel = new \App\Models\TrainingMaterial($this->db);
        return $materialModel->getMaterialsByTrainer($_SESSION['user_id']);
    }

    public function downloadMaterial($id) {
        $materialModel = new \App\Models\TrainingMaterial($this->db);
        $material = $materialModel->getById($id);
        
        if ($material && file_exists($material['file_path'])) {
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $material['file_type']);
            header('Content-Disposition: attachment; filename="' . basename($material['name']) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($material['file_path']));
            readfile($material['file_path']);
            exit;
        } else {
            header('Location: ' . URL_ROOT . '/trainer/materials?error=File+not+found');
            exit();
        }
    }

    public function deleteMaterial($id) {
        $materialModel = new \App\Models\TrainingMaterial($this->db);
        $material = $materialModel->getById($id);
        
        if ($material) {
            // Delete file from filesystem
            if (file_exists($material['file_path'])) {
                unlink($material['file_path']);
            }
            
            // Delete record from database
            if ($materialModel->delete($id)) {
                header('Location: ' . URL_ROOT . '/trainer/materials?success=Material+deleted');
                exit();
            }
        }
        
        header('Location: ' . URL_ROOT . '/trainer/materials?error=Failed+to+delete+material');
        exit();
    }
}

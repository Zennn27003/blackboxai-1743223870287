<?php
namespace App\Controllers;

use App\Database;
use App\Models\User;

class AdminController {
    private $db;

    public function __construct(Database $db) {
        session_start();
        $this->db = $db;
        $this->checkAdminAccess();
    }

    private function checkAdminAccess() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: ' . URL_ROOT . '/home/login');
            exit();
        }
    }

    public function dashboard() {
        $userModel = new User($this->db);
        $users = $userModel->getAllUsers();
        
        $data = [
            'title' => 'Admin Dashboard',
            'users' => $users
        ];

        require_once 'views/admin/dashboard.php';
    }

    public function users() {
        $userModel = new User($this->db);
        $users = $userModel->getAllUsers();
        
        require_once 'views/admin/users.php';
    }

    public function courses() {
        require_once 'views/admin/courses.php';
    }

    public function reports() {
        require_once 'views/admin/reports.php';
    }
}
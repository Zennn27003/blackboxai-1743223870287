<?php
namespace App\Controllers;

use App\Database;

class HomeController {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function index() {
        // Check if user is logged in
        session_start();
        if (isset($_SESSION['user_id'])) {
            // Redirect to appropriate dashboard based on role
            switch ($_SESSION['role']) {
                case 'admin':
                    header('Location: ' . URL_ROOT . '/admin/dashboard');
                    break;
                case 'trainer':
                    header('Location: ' . URL_ROOT . '/trainer/dashboard');
                    break;
                case 'trainee':
                    header('Location: ' . URL_ROOT . '/trainee/dashboard');
                    break;
            }
            exit();
        }

        // Show public home page
        require_once 'views/home.php';
    }

    public function login() {
        session_start();
        
        // Redirect if already logged in
        if (isset($_SESSION['user_id'])) {
            $this->index();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            $userModel = new \App\Models\User($this->db);
            $user = $userModel->login($email, $password);

            if ($user) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                
                // Redirect to appropriate dashboard
                $this->index();
                return;
            } else {
                header('Location: ' . URL_ROOT . '/home/login?error=Invalid+credentials');
                exit();
            }
        }

        require_once 'views/auth/login.php';
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ' . URL_ROOT);
        exit();
    }
}
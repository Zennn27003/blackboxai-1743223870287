<?php
namespace App\Controllers;

use App\Database;
use App\Models\User;

class TraineeController {
    private $db;

    public function __construct(Database $db) {
        session_start();
        $this->db = $db;
        $this->checkTraineeAccess();
    }

    private function checkTraineeAccess() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'trainee') {
            header('Location: ' . URL_ROOT . '/home/login');
            exit();
        }
    }

    public function dashboard() {
        $data = [
            'title' => 'Trainee Dashboard',
            'upcoming_trainings' => $this->getUpcomingTrainings(),
            'completed_courses' => $this->getCompletedCourses()
        ];

        require_once 'views/trainee/dashboard.php';
    }

    public function courses() {
        $data = [
            'title' => 'My Courses',
            'enrolled_courses' => $this->getEnrolledCourses(),
            'available_courses' => $this->getAvailableCourses()
        ];

        require_once 'views/trainee/courses.php';
    }

    private function getUpcomingTrainings() {
        // TODO: Implement actual database query
        return [
            ['id' => 1, 'title' => 'CPR Certification', 'date' => '2023-12-15', 'time' => '09:00'],
            ['id' => 2, 'title' => 'Infection Control', 'date' => '2023-12-20', 'time' => '11:00']
        ];
    }

    private function getCompletedCourses() {
        // TODO: Implement actual database query
        return [
            ['id' => 3, 'title' => 'HIPAA Compliance', 'completed_date' => '2023-11-30', 'score' => '95%']
        ];
    }

    private function getEnrolledCourses() {
        // TODO: Implement actual database query
        return [
            ['id' => 1, 'title' => 'CPR Certification', 'progress' => '30%', 'next_session' => '2023-12-15'],
            ['id' => 2, 'title' => 'Infection Control', 'progress' => '0%', 'next_session' => '2023-12-20']
        ];
    }

    private function getAvailableCourses() {
        // TODO: Implement actual database query
        return [
            ['id' => 4, 'title' => 'Emergency Response', 'duration' => '4 hours'],
            ['id' => 5, 'title' => 'Patient Safety', 'duration' => '2 hours']
        ];
    }
}
<?php
require_once 'models/User.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->userModel->login($_POST['username'], $_POST['password']);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php?action=dashboard");
                exit;
            } else {
                $error = "Credenciales incorrectas";
                require 'views/login.php';
            }
        } else {
            require 'views/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php");
    }
    
    public function register() {
         if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
             die("Acceso denegado");
         }
         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
             $this->userModel->register($_POST['username'], $_POST['password'], $_POST['role']);
             header("Location: index.php?action=users");
         }
    }
}
?>
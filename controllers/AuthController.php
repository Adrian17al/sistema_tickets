<?php
require_once 'models/User.php';

class AuthController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->userModel->login($_POST['username'], $_POST['password']);
            
            if ($result === 'suspended') {
                $error = "Tu cuenta ha sido suspendida. Contacta al administrador.";
                require 'views/login.php';
            } elseif ($result && is_array($result)) {
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['username'] = $result['username'];
                $_SESSION['role'] = $result['role'];
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
}
?>
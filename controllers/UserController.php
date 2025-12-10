<?php
require_once 'models/User.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    // Listar usuarios
    public function index() {
        if ($_SESSION['role'] !== 'admin') die("Acceso denegado");
        
        $users = $this->userModel->getAll();
        require 'views/users/list.php';
    }

    // Mostrar formulario y crear usuario
    public function create() {
        if ($_SESSION['role'] !== 'admin') die("Acceso denegado");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            // Validación básica
            if (empty($username) || empty($password)) {
                $error = "Todos los campos son obligatorios";
                require 'views/users/create.php';
                return;
            }

            try {
                if ($this->userModel->register($username, $password, $role)) {
                    header("Location: index.php?action=users&msg=created");
                } else {
                    $error = "Error al crear usuario (quizás el nombre ya existe)";
                    require 'views/users/create.php';
                }
            } catch (Exception $e) {
                $error = "Error: " . $e->getMessage();
                require 'views/users/create.php';
            }
        } else {
            require 'views/users/create.php';
        }
    }
}
?>
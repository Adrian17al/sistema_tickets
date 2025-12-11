<?php
require_once 'models/User.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function index() {
        if ($_SESSION['role'] !== 'admin') die("Acceso denegado");
        $users = $this->userModel->getAll();
        require 'views/users/list.php';
    }

    public function create() {
        if ($_SESSION['role'] !== 'admin') die("Acceso denegado");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            if (empty($username) || empty($password)) {
                $error = "Todos los campos son obligatorios";
                require 'views/users/create.php';
                return;
            }

            try {
                if ($this->userModel->register($username, $password, $role)) {
                    header("Location: index.php?action=users&msg=created");
                } else {
                    $error = "Error al crear usuario";
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

    // Suspender o reactivar usuario
    public function toggleSuspend() {
        if ($_SESSION['role'] !== 'admin') die("Acceso denegado");
        
        if (isset($_GET['id'])) {
            // Evitar que el admin se suspenda a sí mismo
            if ($_GET['id'] == $_SESSION['user_id']) {
                header("Location: index.php?action=users&error=self_suspend");
                exit;
            }
            
            $this->userModel->toggleSuspension($_GET['id']);
            header("Location: index.php?action=users&msg=updated");
        }
    }
}
?>
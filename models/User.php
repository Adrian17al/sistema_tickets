<?php
class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $password, $role = 'user') {
        $query = "INSERT INTO " . $this->table_name . " (username, password, role, is_suspended) VALUES (:username, :password, :role, 0)";
        $stmt = $this->conn->prepare($query);
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":role", $role);
        return $stmt->execute();
    }

    public function login($username, $password) {
        $query = "SELECT id, username, password, role, is_suspended FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if(password_verify($password, $row['password'])) {
                // Validación estricta de suspensión
                if($row['is_suspended'] == 1) {
                    return 'suspended';
                }
                return $row;
            }
        }
        return false;
    }

    public function getAll() {
        // Aseguramos que traiga is_suspended
        $query = "SELECT id, username, role, is_suspended, created_at FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CORRECCIÓN PRINCIPAL:
    // Hacemos el cambio (toggle) directamente en SQL para evitar errores de lógica en PHP
    public function toggleSuspension($user_id) {
        // Si es 1 lo pone en 0, si es 0 (o NULL) lo pone en 1.
        $query = "UPDATE " . $this->table_name . " 
                  SET is_suspended = CASE WHEN is_suspended = 1 THEN 0 ELSE 1 END 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $user_id);
        return $stmt->execute();
    }
}
?>
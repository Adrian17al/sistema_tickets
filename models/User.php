<?php
class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($username, $password, $role = 'user') {
        $query = "INSERT INTO " . $this->table_name . " (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->conn->prepare($query);
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":role", $role);
        return $stmt->execute();
    }

    public function login($username, $password) {
        $query = "SELECT id, username, password, role FROM " . $this->table_name . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        
        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Primero intentamos verificar usando hashes (bcrypt/argon2, etc.)
            if (password_verify($password, $row['password'])) {
                return $row;
            }

            // Si falla la verificación por hash, posiblemente la contraseña
            // esté almacenada en texto plano (migración/seed antiguo).
            // Comprobamos igualdad directa y, si coincide, re-hasheamos
            // la contraseña para mejorar la seguridad.
            if ($row['password'] === $password) {
                $new_hash = password_hash($password, PASSWORD_BCRYPT);
                $update = "UPDATE " . $this->table_name . " SET password = :password WHERE id = :id";
                $updStmt = $this->conn->prepare($update);
                $updStmt->bindParam(':password', $new_hash);
                $updStmt->bindParam(':id', $row['id']);
                try {
                    $updStmt->execute();
                    $row['password'] = $new_hash;
                } catch (Exception $e) {
                    // Si falla el rehash/update, ignoramos y devolvemos el usuario igualmente.
                }
                return $row;
            }
        }
        return false;
    }

    public function getAll() {
        $query = "SELECT id, username, role FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
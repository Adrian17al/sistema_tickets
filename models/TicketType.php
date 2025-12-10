<?php
class TicketType {
    private $conn;
    public function __construct($db) { $this->conn = $db; }

    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM ticket_types WHERE is_active = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($name) {
        $stmt = $this->conn->prepare("INSERT INTO ticket_types (name) VALUES (:name)");
        $stmt->bindParam(":name", $name);
        return $stmt->execute();
    }
    
    public function delete($id) {
         $stmt = $this->conn->prepare("DELETE FROM ticket_types WHERE id = :id");
         $stmt->bindParam(":id", $id);
         return $stmt->execute();
    }
}
?>
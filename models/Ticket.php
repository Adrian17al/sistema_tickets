<?php
class Ticket {
    private $conn;
    private $table_name = "tickets";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Crear ticket
    public function create($subject, $description, $type_id, $created_by) {
        $query = "INSERT INTO " . $this->table_name . " (subject, description, type_id, created_by) VALUES (:subject, :description, :type_id, :created_by)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":subject", $subject);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":type_id", $type_id);
        $stmt->bindParam(":created_by", $created_by);
        return $stmt->execute();
    }

    // Obtener todos los tickets con nombres relacionados
    public function getAll($filter = null) {
        $query = "SELECT t.*, u.username as creator, a.username as assigned, tp.name as type_name 
                  FROM " . $this->table_name . " t
                  LEFT JOIN users u ON t.created_by = u.id
                  LEFT JOIN users a ON t.assigned_to = a.id
                  LEFT JOIN ticket_types tp ON t.type_id = tp.id";
        
        if ($filter) {
            $query .= " WHERE t.status = :status";
        }
        
        $query .= " ORDER BY t.created_at DESC";
        $stmt = $this->conn->prepare($query);
        
        if ($filter) {
            $stmt->bindParam(":status", $filter);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lógica de BLOQUEO: Asignar ticket a usuario (Race condition safe)
    public function assignToUser($ticket_id, $user_id) {
        // Solo asigna si assigned_to es NULL
        $query = "UPDATE " . $this->table_name . " 
                  SET assigned_to = :user_id, status = 'En proceso' 
                  WHERE id = :ticket_id AND assigned_to IS NULL";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":ticket_id", $ticket_id);
        $stmt->execute();
        
        return $stmt->rowCount() > 0; // Retorna true si se actualizó (éxito), false si ya estaba tomado
    }

    public function updateStatus($ticket_id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :ticket_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":ticket_id", $ticket_id);
        return $stmt->execute();
    }

    public function getStats() {
        $stats = [];
        
        // Total tickets
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM " . $this->table_name);
        $stats['total'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

        // Por estado
        $stmt = $this->conn->query("SELECT status, COUNT(*) as count FROM " . $this->table_name . " GROUP BY status");
        $stats['by_status'] = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        return $stats;
    }
}
?>
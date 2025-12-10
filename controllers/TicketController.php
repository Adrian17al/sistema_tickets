<?php
require_once 'models/Ticket.php';
require_once 'models/TicketType.php';

class TicketController {
    private $ticketModel;
    private $typeModel;

    public function __construct($db) {
        $this->ticketModel = new Ticket($db);
        $this->typeModel = new TicketType($db);
    }

    public function index() {
        $tickets = $this->ticketModel->getAll();
        require 'views/tickets/list.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->ticketModel->create($_POST['subject'], $_POST['description'], $_POST['type_id'], $_SESSION['user_id']);
            header("Location: index.php?action=tickets");
        } else {
            $types = $this->typeModel->getAll();
            require 'views/tickets/create.php';
        }
    }

    public function assign() {
        $ticket_id = $_GET['id'];
        // Intenta asignar. Si falla es porque alguien más lo tomó.
        if ($this->ticketModel->assignToUser($ticket_id, $_SESSION['user_id'])) {
            header("Location: index.php?action=tickets&msg=assigned");
        } else {
            header("Location: index.php?action=tickets&error=locked");
        }
    }

    public function complete() {
        $ticket_id = $_GET['id'];
        $this->ticketModel->updateStatus($ticket_id, 'Completado');
        header("Location: index.php?action=tickets");
    }
    
    public function manageTypes() {
        if ($_SESSION['role'] !== 'admin') die("Acceso denegado");
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['delete_id'])) {
                $this->typeModel->delete($_POST['delete_id']);
            } else {
                $this->typeModel->create($_POST['name']);
            }
        }
        $types = $this->typeModel->getAll();
        require 'views/admin/types.php';
    }
}
?>
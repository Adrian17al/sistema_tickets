<?php
require_once 'models/Ticket.php';

class DashboardController {
    private $ticketModel;

    public function __construct($db) {
        $this->ticketModel = new Ticket($db);
    }

    public function index() {
        $stats = $this->ticketModel->getStats();
        require 'views/dashboard.php';
    }
}
?>
<?php
session_start();
require_once 'config/database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/TicketController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/UserController.php';

$database = new Database();
$db = $database->getConnection();

$action = $_GET['action'] ?? 'dashboard';

// Middleware simple
if (!isset($_SESSION['user_id']) && $action !== 'login') {
    header("Location: index.php?action=login");
    exit;
}

switch ($action) {
    case 'login':
        (new AuthController($db))->login();
        break;
    case 'logout':
        (new AuthController($db))->logout();
        break;
    
    // Dashboard
    case 'dashboard':
        (new DashboardController($db))->index();
        break;
    
    // Tickets
    case 'tickets':
        (new TicketController($db))->index();
        break;
    case 'create_ticket':
        (new TicketController($db))->create();
        break;
    case 'take_ticket':
        (new TicketController($db))->assign();
        break;
    case 'complete_ticket':
        (new TicketController($db))->complete();
        break;
    case 'types':
        (new TicketController($db))->manageTypes();
        break;

    // Usuarios
    case 'users':
        (new UserController($db))->index();
        break;
    case 'create_user':
        (new UserController($db))->create();
        break;
    case 'suspend_user': // NUEVA RUTA
        (new UserController($db))->toggleSuspend();
        break;

    default:
        (new DashboardController($db))->index();
        break;
}
?>
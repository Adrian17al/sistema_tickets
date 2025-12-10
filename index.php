<?php
session_start();
require_once 'config/database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/TicketController.php';
require_once 'controllers/DashboardController.php';

// Conexión DB
$database = new Database();
$db = $database->getConnection();

// Router Básico
$action = $_GET['action'] ?? 'dashboard';

// Middleware simple de autenticación
if (!isset($_SESSION['user_id']) && $action !== 'login') {
    header("Location: index.php?action=login");
    exit;
}

// Dispatcher
switch ($action) {
    case 'login':
        $controller = new AuthController($db);
        $controller->login();
        break;
    case 'logout':
        $controller = new AuthController($db);
        $controller->logout();
        break;
    case 'dashboard':
        $controller = new DashboardController($db);
        $controller->index();
        break;
    case 'tickets':
        $controller = new TicketController($db);
        $controller->index();
        break;
    case 'create_ticket':
        $controller = new TicketController($db);
        $controller->create();
        break;
    case 'take_ticket':
        $controller = new TicketController($db);
        $controller->assign();
        break;
    case 'complete_ticket':
        $controller = new TicketController($db);
        $controller->complete();
        break;
    case 'types':
        $controller = new TicketController($db);
        $controller->manageTypes();
        break;
    default:
        $controller = new DashboardController($db);
        $controller->index();
        break;
}
?>
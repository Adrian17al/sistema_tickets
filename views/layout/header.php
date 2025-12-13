<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Tickets MVC</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen text-gray-800 flex flex-col">
<nav class="nav-gradient text-white p-4 shadow-md sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index.php?action=dashboard" class="text-xl font-bold flex items-center hover:text-blue-100 transition">
            <i class="fas fa-ticket-alt mr-2"></i>SupportDesk
        </a>
        <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none p-2">
            <i class="fas fa-bars text-2xl"></i>
        </button>
        <div class="hidden md:flex items-center space-x-4">
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="flex flex-col text-right mr-2">
                    <span class="text-sm font-semibold"><?php echo $_SESSION['username']; ?></span>
                    <span class="text-xs text-blue-200 uppercase tracking-wider"><?php echo $_SESSION['role']; ?></span>
                </div>
                <a href="index.php?action=tickets" class="hover:bg-white/10 px-3 py-2 rounded transition flex items-center"><i class="fas fa-clipboard-list mr-2"></i> Tickets</a>
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <a href="index.php?action=users" class="hover:bg-white/10 px-3 py-2 rounded transition flex items-center"><i class="fas fa-users mr-2"></i> Usuarios</a>
                    <a href="index.php?action=types" class="hover:bg-white/10 px-3 py-2 rounded transition flex items-center"><i class="fas fa-cogs mr-2"></i> Config</a>
                <?php endif; ?>
                <a href="index.php?action=logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow btn-transition confirm-logout"><i class="fas fa-sign-out-alt mr-2"></i> Salir</a>
            <?php endif; ?>
        </div>
    </div>
    <div id="mobile-menu" class="hidden md:hidden mt-4 border-t border-blue-400 pt-4 animate-fade-in">
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="flex flex-col space-y-2">
                <div class="text-blue-200 text-sm mb-2 px-2">Conectado como: <strong><?php echo $_SESSION['username']; ?></strong></div>
                <a href="index.php?action=tickets" class="block py-3 px-4 hover:bg-white/10 rounded font-medium"><i class="fas fa-clipboard-list mr-2 w-6"></i> Tickets</a>
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <a href="index.php?action=users" class="block py-3 px-4 hover:bg-white/10 rounded font-medium"><i class="fas fa-users mr-2 w-6"></i> Usuarios</a>
                    <a href="index.php?action=types" class="block py-3 px-4 hover:bg-white/10 rounded font-medium"><i class="fas fa-cogs mr-2 w-6"></i> Configuración</a>
                <?php endif; ?>
                <a href="index.php?action=logout" class="block py-3 px-4 bg-red-500 rounded text-center mt-2 font-bold shadow confirm-logout">Cerrar Sesión</a>
            </div>
        <?php endif; ?>
    </div>
</nav>
<div class="container mx-auto p-4 md:p-6 flex-grow animate-fade-in">



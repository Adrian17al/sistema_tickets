<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OctoFix - Soporte</title>
    <!-- Favicon: Icono en la pestaña del navegador -->
    <link rel="icon" href="assets/img/octofix.png" type="image/png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Paleta extraída del Logo OctoFix
                        cyan: { 500: '#06B6D4', 600: '#0891B2' },   // El color del pulpo
                        slate: { 800: '#1E293B', 900: '#0F172A' },  // El fondo oscuro del logo
                        orange: { 500: '#F97316', 600: '#EA580C' }  // El color de "Fix" y herramientas
                    }
                }
            }
        }
    </script>
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-slate-50 min-h-screen text-gray-800 flex flex-col">
<nav class="nav-gradient text-white p-3 shadow-lg sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        <!-- BRANDING: Logo de Imagen + Texto Coloreado -->
        <a href="index.php?action=dashboard" class="group flex items-center transition">
            <!-- Imagen del Logo -->
            <img src="assets/img/octofix.png" alt="OctoFix Logo" class="h-12 w-12 mr-3 rounded-full shadow-md border-2 border-white/20 group-hover:border-white/50 transition">
            
            <!-- Texto del Logo (Octo en blanco, Fix en naranja como el logo) -->
            <div class="text-2xl font-bold tracking-tight">
                <span class="text-white">Octo</span><span class="text-orange-500 drop-shadow-sm">Fix</span>
            </div>
        </a>

        <!-- Botón Móvil -->
        <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none p-2 hover:bg-white/10 rounded">
            <i class="fas fa-bars text-2xl"></i>
        </button>

        <!-- Menú Desktop -->
        <div class="hidden md:flex items-center space-x-4">
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="flex flex-col text-right mr-3">
                    <span class="text-sm font-semibold opacity-90"><?php echo $_SESSION['username']; ?></span>
                    <span class="text-xs bg-slate-800 px-2 py-0.5 rounded text-cyan-200 uppercase tracking-wider text-center border border-cyan-500/30"><?php echo $_SESSION['role']; ?></span>
                </div>
                
                <a href="index.php?action=tickets" class="hover:bg-white/10 px-4 py-2 rounded-lg transition flex items-center font-medium">
                    <i class="fas fa-clipboard-list mr-2 text-cyan-300"></i> Tickets
                </a>
                
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <a href="index.php?action=users" class="hover:bg-white/10 px-4 py-2 rounded-lg transition flex items-center font-medium">
                        <i class="fas fa-users mr-2 text-cyan-300"></i> Usuarios
                    </a>
                    <a href="index.php?action=types" class="hover:bg-white/10 px-4 py-2 rounded-lg transition flex items-center font-medium">
                        <i class="fas fa-cogs mr-2 text-cyan-300"></i> Config
                    </a>
                <?php endif; ?>
                
                <a href="index.php?action=logout" class="bg-orange-600 hover:bg-orange-700 text-white px-5 py-2 rounded-lg shadow-md btn-transition confirm-logout font-bold border border-orange-700">
                    <i class="fas fa-sign-out-alt mr-2"></i> Salir
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Menú Móvil -->
    <div id="mobile-menu" class="hidden md:hidden mt-4 border-t border-cyan-800 pt-4 animate-fade-in">
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="flex flex-col space-y-2">
                <div class="bg-slate-800/50 p-3 rounded-lg mb-2 flex items-center justify-between border border-cyan-900">
                    <div>
                        <div class="text-cyan-200 text-xs uppercase">Usuario</div>
                        <div class="font-bold text-white"><?php echo $_SESSION['username']; ?></div>
                    </div>
                    <span class="text-xs font-bold px-2 py-1 rounded bg-orange-600 text-white"><?php echo strtoupper(substr($_SESSION['role'], 0, 1)); ?></span>
                </div>
                
                <a href="index.php?action=tickets" class="block py-3 px-4 hover:bg-white/10 rounded-lg font-medium"><i class="fas fa-clipboard-list mr-3 w-6 text-center text-cyan-400"></i> Tickets</a>
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <a href="index.php?action=users" class="block py-3 px-4 hover:bg-white/10 rounded-lg font-medium"><i class="fas fa-users mr-3 w-6 text-center text-cyan-400"></i> Usuarios</a>
                    <a href="index.php?action=types" class="block py-3 px-4 hover:bg-white/10 rounded-lg font-medium"><i class="fas fa-cogs mr-3 w-6 text-center text-cyan-400"></i> Configuración</a>
                <?php endif; ?>
                <a href="index.php?action=logout" class="block py-3 px-4 bg-orange-600 hover:bg-orange-700 rounded-lg text-center mt-4 font-bold shadow text-white confirm-logout">Cerrar Sesión</a>
            </div>
        <?php endif; ?>
    </div>
</nav>
<div class="container mx-auto p-4 md:p-6 flex-grow animate-fade-in">

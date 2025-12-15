<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OctoFix - Soporte</title>
    <link rel="icon" href="assets/img/octofix.png" type="image/png">
    
    <!-- Script Anti-FOUC para Modo Oscuro -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class', // Activación manual del modo oscuro
            theme: {
                extend: {
                    colors: {
                        cyan: { 500: '#06B6D4', 600: '#0891B2' },
                        slate: { 800: '#1E293B', 900: '#0F172A' },
                        orange: { 500: '#F97316', 600: '#EA580C' }
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
<body class="bg-slate-50 min-h-screen text-gray-800 flex flex-col transition-colors duration-300">
<nav class="nav-gradient text-white p-3 shadow-lg sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="index.php?action=dashboard" class="group flex items-center transition">
            <img src="assets/img/octofix.png" alt="OctoFix Logo" class="h-12 w-12 mr-3 rounded-full shadow-md border-2 border-white/20 group-hover:border-white/50 transition">
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
            
            <!-- SWITCH MODO OSCURO (DESKTOP) -->
            <label class="inline-flex items-center cursor-pointer mr-2" title="Cambiar Tema">
                <input type="checkbox" id="theme-toggle-desktop" class="sr-only peer" onchange="toggleTheme('desktop')">
                <div class="relative w-14 h-7 bg-slate-600 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-cyan-300 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-cyan-500 flex items-center justify-between px-1.5">
                    <i class="fas fa-moon text-xs text-slate-400"></i>
                    <i class="fas fa-sun text-xs text-yellow-300"></i>
                </div>
            </label>

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
        <div class="flex justify-between items-center px-4 mb-4">
            <span class="text-cyan-200 text-sm font-bold">Modo Oscuro</span>
            
            <!-- SWITCH MODO OSCURO (MÓVIL) -->
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" id="theme-toggle-mobile" class="sr-only peer" onchange="toggleTheme('mobile')">
                <div class="relative w-11 h-6 bg-slate-600 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-cyan-500"></div>
            </label>
        </div>

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

<!-- Lógica del Tema Actualizada -->
<script>
    // Inicializar el estado de los interruptores basado en el tema actual
    function initThemeToggles() {
        const isDark = document.documentElement.classList.contains('dark');
        const desktopToggle = document.getElementById('theme-toggle-desktop');
        const mobileToggle = document.getElementById('theme-toggle-mobile');
        
        if(desktopToggle) desktopToggle.checked = isDark;
        if(mobileToggle) mobileToggle.checked = isDark;
    }

    // Función que se ejecuta al cambiar cualquier interruptor
    function toggleTheme(source) {
        const desktopToggle = document.getElementById('theme-toggle-desktop');
        const mobileToggle = document.getElementById('theme-toggle-mobile');
        
        // Determinar si debemos activar o desactivar basado en quién lo llamó
        let isChecked = false;
        if (source === 'desktop' && desktopToggle) isChecked = desktopToggle.checked;
        if (source === 'mobile' && mobileToggle) isChecked = mobileToggle.checked;
        
        if (isChecked) {
            document.documentElement.classList.add('dark');
            localStorage.theme = 'dark';
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.theme = 'light';
        }
        
        // Sincronizar el otro interruptor para que no queden disparejos
        if(desktopToggle) desktopToggle.checked = isChecked;
        if(mobileToggle) mobileToggle.checked = isChecked;
    }

    // Ejecutar al cargar la página
    window.addEventListener('DOMContentLoaded', initThemeToggles);
</script>

<div class="container mx-auto p-4 md:p-6 flex-grow animate-fade-in">


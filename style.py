import os

project_name = "sistema_tickets"

# Definimos el contenido de los archivos de estilo, scripts y vistas actualizadas
files = {
    # 1. Archivo CSS Personalizado (Mejorado)
    f"{project_name}/assets/css/styles.css": """/* Fuente personalizada */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

body {
    font-family: 'Inter', sans-serif;
    background-color: #f8f9fa;
}

/* Scrollbar personalizado */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}
::-webkit-scrollbar-track {
    background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}
::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* --- ANIMACIONES --- */

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fadeIn 0.4s ease-out forwards;
}

/* Efecto cascada para tablas y tarjetas */
tbody tr, .mobile-card {
    opacity: 0;
    animation: fadeIn 0.3s ease-out forwards;
}
/* Retrasos progresivos */
tbody tr:nth-child(1), .mobile-card:nth-child(1) { animation-delay: 0.05s; }
tbody tr:nth-child(2), .mobile-card:nth-child(2) { animation-delay: 0.1s; }
tbody tr:nth-child(3), .mobile-card:nth-child(3) { animation-delay: 0.15s; }
tbody tr:nth-child(4), .mobile-card:nth-child(4) { animation-delay: 0.2s; }
tbody tr:nth-child(5), .mobile-card:nth-child(5) { animation-delay: 0.25s; }

/* --- COMPONENTES --- */

.card-hover {
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}
.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.nav-gradient {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
}

.btn-transition {
    transition: all 0.2s;
}
.btn-transition:active {
    transform: scale(0.95);
}

/* Alertas flotantes */
.alert-float {
    transition: opacity 0.5s ease-out;
}
""",

    # 2. Archivo JavaScript (Sin cambios mayores, lógica UI)
    f"{project_name}/assets/js/scripts.js": """document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Menú Móvil
    const btnMobile = document.getElementById('mobile-menu-btn');
    const menuMobile = document.getElementById('mobile-menu');
    
    if (btnMobile && menuMobile) {
        btnMobile.addEventListener('click', () => {
            menuMobile.classList.toggle('hidden');
        });
    }

    // 2. Auto-ocultar alertas después de 3 segundos
    const alerts = document.querySelectorAll('.alert-dismissible');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500); 
            });
        }, 4000);
    }

    // 3. Buscador en tiempo real (Compatible con Móvil y Desktop)
    const searchInput = document.getElementById('table-search');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            
            // Filtrar filas de tabla (Desktop)
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(value) > -1 ? '' : 'none';
            });

            // Filtrar tarjetas (Móvil)
            const cards = document.querySelectorAll('.mobile-card');
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.indexOf(value) > -1 ? '' : 'none';
            });
        });
    }
});
""",

    # 3. Header Actualizado (Padding responsivo ajustado)
    f"{project_name}/views/layout/header.php": """<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Tickets MVC</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen text-gray-800 flex flex-col">
<nav class="nav-gradient text-white p-4 shadow-md sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="index.php?action=dashboard" class="text-xl font-bold flex items-center hover:text-blue-100 transition">
            <i class="fas fa-ticket-alt mr-2"></i>SupportDesk
        </a>

        <!-- Botón Móvil -->
        <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none p-2">
            <i class="fas fa-bars text-2xl"></i>
        </button>

        <!-- Menú Desktop -->
        <div class="hidden md:flex items-center space-x-4">
            <?php if(isset($_SESSION['user_id'])): ?>
                <div class="flex flex-col text-right mr-2">
                    <span class="text-sm font-semibold"><?php echo $_SESSION['username']; ?></span>
                    <span class="text-xs text-blue-200 uppercase tracking-wider"><?php echo $_SESSION['role']; ?></span>
                </div>
                
                <a href="index.php?action=tickets" class="hover:bg-white/10 px-3 py-2 rounded transition flex items-center">
                    <i class="fas fa-clipboard-list mr-2"></i> Tickets
                </a>
                
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <a href="index.php?action=users" class="hover:bg-white/10 px-3 py-2 rounded transition flex items-center">
                        <i class="fas fa-users mr-2"></i> Usuarios
                    </a>
                    <a href="index.php?action=types" class="hover:bg-white/10 px-3 py-2 rounded transition flex items-center">
                        <i class="fas fa-cogs mr-2"></i> Config
                    </a>
                <?php endif; ?>
                
                <a href="index.php?action=logout" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow btn-transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Salir
                </a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Menú Móvil -->
    <div id="mobile-menu" class="hidden md:hidden mt-4 border-t border-blue-400 pt-4 animate-fade-in">
        <?php if(isset($_SESSION['user_id'])): ?>
            <div class="flex flex-col space-y-2">
                <div class="text-blue-200 text-sm mb-2 px-2">Conectado como: <strong><?php echo $_SESSION['username']; ?></strong></div>
                <a href="index.php?action=tickets" class="block py-3 px-4 hover:bg-white/10 rounded font-medium"><i class="fas fa-clipboard-list mr-2 w-6"></i> Tickets</a>
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <a href="index.php?action=users" class="block py-3 px-4 hover:bg-white/10 rounded font-medium"><i class="fas fa-users mr-2 w-6"></i> Usuarios</a>
                    <a href="index.php?action=types" class="block py-3 px-4 hover:bg-white/10 rounded font-medium"><i class="fas fa-cogs mr-2 w-6"></i> Configuración</a>
                <?php endif; ?>
                <a href="index.php?action=logout" class="block py-3 px-4 bg-red-500 rounded text-center mt-2 font-bold shadow">Cerrar Sesión</a>
            </div>
        <?php endif; ?>
    </div>
</nav>
<!-- Ajuste padding móvil p-4 vs md:p-6 -->
<div class="container mx-auto p-4 md:p-6 flex-grow animate-fade-in">
""",

    # 4. Footer
    f"{project_name}/views/layout/footer.php": """</div>
<footer class="bg-white border-t mt-auto">
    <div class="container mx-auto p-6 text-center text-gray-500 text-sm">
        <p>&copy; <?php echo date('Y'); ?> Sistema de Tickets MVC.</p>
    </div>
</footer>
<!-- Custom JS -->
<script src="assets/js/scripts.js"></script>
</body>
</html>""",

    # 5. Lista de Tickets RESPONSIVE (Híbrida: Tabla Desktop / Tarjetas Móvil)
    f"{project_name}/views/tickets/list.php": """<?php include 'views/layout/header.php'; ?>

<!-- Encabezado y Acciones -->
<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    <h2 class="text-2xl font-bold text-gray-800 w-full md:w-auto text-center md:text-left">
        <i class="fas fa-list-alt mr-2 text-blue-600"></i>Gestión de Tickets
    </h2>
    <div class="flex flex-col w-full md:w-auto gap-3 md:flex-row">
        <!-- Buscador JS -->
        <div class="relative w-full md:w-64">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fas fa-search text-gray-400"></i>
            </span>
            <input type="text" id="table-search" placeholder="Buscar ticket..." 
                   class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white border rounded-lg focus:outline-none focus:border-blue-500 shadow-sm transition">
        </div>
        
        <a href="index.php?action=create_ticket" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 shadow-md btn-transition flex items-center justify-center whitespace-nowrap">
            <i class="fas fa-plus mr-2"></i> Nuevo
        </a>
    </div>
</div>

<!-- Alertas -->
<?php if(isset($_GET['error']) && $_GET['error'] == 'locked'): ?>
    <div class="alert-dismissible bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm mb-4 flex items-center justify-between" role="alert">
        <div><i class="fas fa-exclamation-circle mr-2"></i> Error: Ticket bloqueado por otro usuario.</div>
    </div>
<?php endif; ?>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'assigned'): ?>
    <div class="alert-dismissible bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm mb-4 flex items-center justify-between" role="alert">
        <div><i class="fas fa-check-circle mr-2"></i> Asignado correctamente.</div>
    </div>
<?php endif; ?>

<!-- ======================= -->
<!-- VISTA DESKTOP (Tabla)   -->
<!-- ======================= -->
<div class="hidden md:block bg-white shadow-lg rounded-lg overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold tracking-wider border-b">
                    <th class="py-4 px-6 text-left">ID</th>
                    <th class="py-4 px-6 text-left">Asunto</th>
                    <th class="py-4 px-6 text-left">Tipo</th>
                    <th class="py-4 px-6 text-left">Estado</th>
                    <th class="py-4 px-6 text-left">Asignado a</th>
                    <th class="py-4 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
                <?php foreach($tickets as $t): ?>
                <?php 
                    $statusConfig = match($t['status']) {
                        'Sin empezar' => ['bg' => 'bg-red-100', 'text' => 'text-red-600', 'icon' => 'fa-times-circle'],
                        'En proceso' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-600', 'icon' => 'fa-hourglass-half'],
                        'Completado' => ['bg' => 'bg-green-100', 'text' => 'text-green-600', 'icon' => 'fa-check-circle'],
                        default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'icon' => 'fa-circle']
                    };
                ?>
                <tr class="hover:bg-blue-50 transition duration-150">
                    <td class="py-4 px-6 font-bold text-blue-600">#<?php echo $t['id']; ?></td>
                    <td class="py-4 px-6 font-medium text-gray-800"><?php echo htmlspecialchars($t['subject']); ?></td>
                    <td class="py-4 px-6"><span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold border"><?php echo $t['type_name']; ?></span></td>
                    <td class="py-4 px-6">
                        <span class="<?php echo $statusConfig['bg'] . ' ' . $statusConfig['text']; ?> px-3 py-1 rounded-full text-xs font-bold inline-flex items-center">
                            <i class="fas <?php echo $statusConfig['icon']; ?> mr-1"></i> <?php echo $t['status']; ?>
                        </span>
                    </td>
                    <td class="py-4 px-6">
                        <?php echo $t['assigned'] ? '<span class="font-semibold text-gray-700">'.$t['assigned'].'</span>' : '<span class="text-gray-400 italic">--</span>'; ?>
                    </td>
                    <td class="py-4 px-6 text-center">
                        <?php if($t['status'] === 'Sin empezar'): ?>
                            <a href="index.php?action=take_ticket&id=<?php echo $t['id']; ?>" class="bg-white border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white px-3 py-1 rounded text-xs font-bold transition btn-transition">Tomar</a>
                        <?php elseif($t['status'] === 'En proceso' && $t['assigned_to'] == $_SESSION['user_id']): ?>
                            <a href="index.php?action=complete_ticket&id=<?php echo $t['id']; ?>" class="bg-green-500 text-white px-3 py-1 rounded text-xs font-bold hover:bg-green-600 transition btn-transition">Terminar</a>
                        <?php else: ?>
                            <span class="text-gray-300"><i class="fas fa-eye"></i></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ======================= -->
<!-- VISTA MÓVIL (Tarjetas)  -->
<!-- ======================= -->
<div class="md:hidden space-y-4">
    <?php foreach($tickets as $t): ?>
    <?php 
        $statusConfig = match($t['status']) {
            'Sin empezar' => ['bg' => 'bg-red-50', 'text' => 'text-red-600', 'border' => 'border-red-200'],
            'En proceso' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-600', 'border' => 'border-yellow-200'],
            'Completado' => ['bg' => 'bg-green-50', 'text' => 'text-green-600', 'border' => 'border-green-200'],
            default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'border' => 'border-gray-200']
        };
    ?>
    <div class="mobile-card bg-white p-4 rounded-lg shadow-sm border border-gray-200 relative overflow-hidden">
        <!-- Status Stripe -->
        <div class="absolute left-0 top-0 bottom-0 w-1 <?php echo str_replace('text-', 'bg-', $statusConfig['text']); ?>"></div>
        
        <div class="flex justify-between items-start mb-2 pl-3">
            <span class="font-bold text-lg text-gray-800">#<?php echo $t['id']; ?></span>
            <span class="<?php echo $statusConfig['bg'] . ' ' . $statusConfig['text']; ?> px-2 py-1 rounded text-xs font-bold border <?php echo $statusConfig['border']; ?>">
                <?php echo $t['status']; ?>
            </span>
        </div>
        
        <h3 class="font-bold text-gray-900 text-lg mb-1 pl-3"><?php echo htmlspecialchars($t['subject']); ?></h3>
        <p class="text-sm text-gray-500 mb-3 pl-3 flex items-center">
            <i class="fas fa-tag mr-2 text-gray-400"></i> <?php echo $t['type_name']; ?>
        </p>

        <div class="flex justify-between items-center bg-gray-50 p-3 rounded mt-2 ml-3">
            <div class="text-sm">
                <span class="text-gray-400 block text-xs uppercase">Asignado a</span>
                <span class="font-medium text-gray-700"><?php echo $t['assigned'] ? $t['assigned'] : 'Sin asignar'; ?></span>
            </div>
            
            <!-- Mobile Actions -->
            <?php if($t['status'] === 'Sin empezar'): ?>
                <a href="index.php?action=take_ticket&id=<?php echo $t['id']; ?>" class="bg-blue-600 text-white px-4 py-2 rounded shadow text-sm font-bold">Tomar</a>
            <?php elseif($t['status'] === 'En proceso' && $t['assigned_to'] == $_SESSION['user_id']): ?>
                <a href="index.php?action=complete_ticket&id=<?php echo $t['id']; ?>" class="bg-green-600 text-white px-4 py-2 rounded shadow text-sm font-bold">Terminar</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
    
    <?php if(empty($tickets)): ?>
        <div class="text-center p-8 bg-white rounded shadow-sm text-gray-400">
            <i class="fas fa-inbox text-4xl mb-3"></i>
            <p>No hay tickets disponibles</p>
        </div>
    <?php endif; ?>
</div>

<?php include 'views/layout/footer.php'; ?>"""
}

# Creación de carpetas y archivos
for path, content in files.items():
    # Asegurar que el directorio js exista
    os.makedirs(os.path.dirname(path), exist_ok=True)
    with open(path, "w", encoding="utf-8") as f:
        f.write(content)

print(f"Mejoras de Flujo (JS) y Presentación Responsive (CSS) aplicadas en '{project_name}'")
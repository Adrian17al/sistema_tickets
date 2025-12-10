<?php include 'views/layout/header.php'; ?>
<div class="flex justify-between items-end mb-6">
    <div>
        <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>
        <p class="text-gray-500">Resumen general del sistema</p>
    </div>
    <div class="text-sm text-gray-400">
        <?php echo date('d/m/Y'); ?>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card Total -->
    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500 card-hover">
        <div class="flex justify-between items-center">
            <div>
                <div class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Total Tickets</div>
                <div class="text-4xl font-bold text-gray-800 mt-2"><?php echo $stats['total']; ?></div>
            </div>
            <div class="text-blue-200 text-5xl">
                <i class="fas fa-ticket-alt"></i>
            </div>
        </div>
    </div>
    
    <!-- Card Pendientes -->
    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500 card-hover">
        <div class="flex justify-between items-center">
            <div>
                <div class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Sin Empezar</div>
                <div class="text-4xl font-bold text-gray-800 mt-2"><?php echo $stats['by_status']['Sin empezar'] ?? 0; ?></div>
            </div>
            <div class="text-yellow-200 text-5xl">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>
    
    <!-- Card Completados -->
    <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500 card-hover">
        <div class="flex justify-between items-center">
            <div>
                <div class="text-gray-500 text-sm font-semibold uppercase tracking-wide">Completados</div>
                <div class="text-4xl font-bold text-gray-800 mt-2"><?php echo $stats['by_status']['Completado'] ?? 0; ?></div>
            </div>
            <div class="text-green-200 text-5xl">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <h3 class="text-xl font-bold mb-4 text-gray-800 border-b pb-2">Acciones Rápidas</h3>
        <div class="flex flex-wrap gap-3">
            <a href="index.php?action=create_ticket" class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700 btn-transition flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Nuevo Ticket
            </a>
            <a href="index.php?action=tickets" class="bg-gray-100 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-200 btn-transition flex items-center">
                <i class="fas fa-list mr-2"></i> Ver Lista
            </a>
        </div>
    </div>
    
    <div class="bg-gradient-to-br from-blue-600 to-blue-800 p-6 rounded-lg shadow-sm text-white">
        <h3 class="text-xl font-bold mb-2">Estado del Sistema</h3>
        <p class="opacity-90 mb-4">El sistema está funcionando correctamente. Todas las conexiones a la base de datos están activas.</p>
        <div class="flex items-center text-sm bg-white/20 p-2 rounded w-fit">
            <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span> En línea
        </div>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>
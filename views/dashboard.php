<?php include 'views/layout/header.php'; ?>
<h2 class="text-3xl font-bold mb-6">Dashboard Administrativo</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card Total -->
    <div class="bg-white p-6 rounded shadow border-l-4 border-blue-500">
        <div class="text-gray-500">Total Tickets</div>
        <div class="text-4xl font-bold"><?php echo $stats['total']; ?></div>
    </div>
    <!-- Card Pendientes -->
    <div class="bg-white p-6 rounded shadow border-l-4 border-yellow-500">
        <div class="text-gray-500">Sin Empezar</div>
        <div class="text-4xl font-bold"><?php echo $stats['by_status']['Sin empezar'] ?? 0; ?></div>
    </div>
    <!-- Card Completados -->
    <div class="bg-white p-6 rounded shadow border-l-4 border-green-500">
        <div class="text-gray-500">Completados</div>
        <div class="text-4xl font-bold"><?php echo $stats['by_status']['Completado'] ?? 0; ?></div>
    </div>
</div>

<div class="bg-white p-6 rounded shadow">
    <h3 class="text-xl font-bold mb-4">Acciones Rápidas</h3>
    <a href="index.php?action=create_ticket" class="bg-blue-600 text-white px-4 py-2 rounded mr-2">Nuevo Ticket</a>
    <a href="index.php?action=tickets" class="bg-gray-600 text-white px-4 py-2 rounded">Ver Lista de Tickets</a>
</div>
<?php include 'views/layout/footer.php'; ?>
<?php include 'views/layout/header.php'; ?>

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

<?php include 'views/layout/footer.php'; ?>
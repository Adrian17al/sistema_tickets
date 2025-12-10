<?php include 'views/layout/header.php'; ?>
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Gestión de Tickets</h2>
    <a href="index.php?action=create_ticket" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        <i class="fas fa-plus"></i> Nuevo
    </a>
</div>

<?php if(isset($_GET['error']) && $_GET['error'] == 'locked'): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        Error: Este ticket ya fue tomado por otro usuario.
    </div>
<?php endif; ?>

<div class="bg-white shadow rounded overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Asunto</th>
                <th class="py-3 px-6 text-left">Tipo</th>
                <th class="py-3 px-6 text-left">Estado</th>
                <th class="py-3 px-6 text-left">Asignado a</th>
                <th class="py-3 px-6 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            <?php foreach($tickets as $t): ?>
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6"><?php echo $t['id']; ?></td>
                <td class="py-3 px-6 font-medium"><?php echo htmlspecialchars($t['subject']); ?></td>
                <td class="py-3 px-6"><span class="bg-gray-200 rounded-full px-3 py-1 text-xs"><?php echo $t['type_name']; ?></span></td>
                <td class="py-3 px-6">
                    <?php 
                        $color = match($t['status']) {
                            'Sin empezar' => 'bg-red-200 text-red-800',
                            'En proceso' => 'bg-yellow-200 text-yellow-800',
                            'Completado' => 'bg-green-200 text-green-800',
                            default => 'bg-gray-200'
                        };
                    ?>
                    <span class="<?php echo $color; ?> py-1 px-3 rounded-full text-xs"><?php echo $t['status']; ?></span>
                </td>
                <td class="py-3 px-6"><?php echo $t['assigned'] ? $t['assigned'] : '<span class="text-gray-400 italic">Nadie</span>'; ?></td>
                <td class="py-3 px-6 text-center">
                    <?php if($t['status'] === 'Sin empezar'): ?>
                        <a href="index.php?action=take_ticket&id=<?php echo $t['id']; ?>" class="text-blue-600 hover:text-blue-900 font-bold">Tomar Ticket</a>
                    <?php elseif($t['status'] === 'En proceso' && $t['assigned_to'] == $_SESSION['user_id']): ?>
                        <a href="index.php?action=complete_ticket&id=<?php echo $t['id']; ?>" class="text-green-600 hover:text-green-900 font-bold">Terminar</a>
                    <?php else: ?>
                        <span class="text-gray-400">Ver</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'views/layout/footer.php'; ?>
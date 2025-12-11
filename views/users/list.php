<?php include 'views/layout/header.php'; ?>
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Gestión de Usuarios</h2>
    <a href="index.php?action=create_user" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 shadow flex items-center">
        <i class="fas fa-user-plus mr-2"></i> Nuevo Usuario
    </a>
</div>

<!-- Mensajes -->
<?php if(isset($_GET['error']) && $_GET['error'] == 'self_suspend'): ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
        No puedes suspender tu propia cuenta.
    </div>
<?php endif; ?>

<div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-100">
    <table class="min-w-full leading-normal">
        <thead>
            <tr class="bg-gray-50 text-gray-600 uppercase text-xs font-semibold tracking-wider border-b">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Usuario</th>
                <th class="py-3 px-6 text-left">Rol</th>
                <th class="py-3 px-6 text-left">Estado</th>
                <th class="py-3 px-6 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm divide-y divide-gray-100">
            <?php foreach($users as $user): ?>
            <tr class="hover:bg-gray-50 transition <?php echo $user['is_suspended'] ? 'bg-red-50' : ''; ?>">
                <td class="py-4 px-6">#<?php echo $user['id']; ?></td>
                <td class="py-4 px-6 font-medium text-gray-800">
                    <?php echo htmlspecialchars($user['username']); ?>
                    <?php if($user['id'] == $_SESSION['user_id']) echo '<span class="text-xs text-blue-500">(Tú)</span>'; ?>
                </td>
                <td class="py-4 px-6">
                    <span class="<?php echo $user['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'; ?> py-1 px-3 rounded-full text-xs font-bold uppercase tracking-wide">
                        <?php echo $user['role']; ?>
                    </span>
                </td>
                <td class="py-4 px-6">
                    <?php if($user['is_suspended']): ?>
                        <span class="text-red-600 font-bold flex items-center"><i class="fas fa-ban mr-1"></i> Suspendido</span>
                    <?php else: ?>
                        <span class="text-green-600 font-bold flex items-center"><i class="fas fa-check mr-1"></i> Activo</span>
                    <?php endif; ?>
                </td>
                <td class="py-4 px-6 text-center">
                    <?php if($user['id'] != $_SESSION['user_id']): ?>
                        <?php if($user['is_suspended']): ?>
                            <a href="index.php?action=suspend_user&id=<?php echo $user['id']; ?>" 
                               class="text-green-600 hover:text-green-900 font-semibold text-xs border border-green-200 bg-green-50 px-3 py-1 rounded hover:bg-green-100 transition">
                               Reactivar
                            </a>
                        <?php else: ?>
                            <a href="index.php?action=suspend_user&id=<?php echo $user['id']; ?>" 
                               onclick="return confirm('¿Estás seguro de suspender a este usuario? No podrá acceder al sistema.');"
                               class="text-red-600 hover:text-red-900 font-semibold text-xs border border-red-200 bg-red-50 px-3 py-1 rounded hover:bg-red-100 transition">
                               Suspender
                            </a>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="text-gray-400 text-xs italic">--</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'views/layout/footer.php'; ?>
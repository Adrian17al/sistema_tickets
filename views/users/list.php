<?php include 'views/layout/header.php'; ?>
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Gestión de Usuarios</h2>
    <a href="index.php?action=create_user" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        <i class="fas fa-user-plus"></i> Nuevo Usuario
    </a>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'created'): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        Usuario creado exitosamente.
    </div>
<?php endif; ?>

<div class="bg-white shadow rounded overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">ID</th>
                <th class="py-3 px-6 text-left">Usuario</th>
                <th class="py-3 px-6 text-left">Rol</th>
                <th class="py-3 px-6 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            <?php foreach($users as $user): ?>
            <tr class="border-b border-gray-200 hover:bg-gray-100">
                <td class="py-3 px-6"><?php echo $user['id']; ?></td>
                <td class="py-3 px-6 font-medium"><?php echo htmlspecialchars($user['username']); ?></td>
                <td class="py-3 px-6">
                    <span class="<?php echo $user['role'] === 'admin' ? 'bg-purple-200 text-purple-800' : 'bg-blue-200 text-blue-800'; ?> py-1 px-3 rounded-full text-xs">
                        <?php echo $user['role']; ?>
                    </span>
                </td>
                <td class="py-3 px-6">
                    <span class="text-gray-400 text-xs">Editar (Próximamente)</span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'views/layout/footer.php'; ?>
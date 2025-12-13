<?php include 'views/layout/header.php'; ?>
<div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
    <h2 class="text-2xl font-bold text-gray-800 w-full md:w-auto text-center md:text-left">Gestión de Usuarios</h2>
    
    <!-- Buscador (Opcional, reutilizando estilos) -->
    <div class="relative w-full md:w-64 md:hidden">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3"><i class="fas fa-search text-gray-400"></i></span>
        <input type="text" id="user-search-mobile" placeholder="Buscar usuario..." class="w-full py-2 pl-10 pr-4 text-gray-700 bg-white border rounded-lg focus:outline-none focus:border-blue-500 shadow-sm">
    </div>

    <a href="index.php?action=create_user" class="w-full md:w-auto bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 shadow flex items-center justify-center">
        <i class="fas fa-user-plus mr-2"></i> Nuevo Usuario
    </a>
</div>

<!-- Scripts de Alertas -->
<?php if(isset($_GET['msg']) && $_GET['msg'] == 'updated'): ?>
    <script>Swal.fire({icon: 'success', title: '¡Actualizado!', text: 'Estado modificado.', timer: 2000, showConfirmButton: false});</script>
<?php endif; ?>
<?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    <script>Swal.fire({icon: 'success', title: '¡Eliminado!', text: 'Usuario eliminado.', timer: 2000, showConfirmButton: false});</script>
<?php endif; ?>
<?php if(isset($_GET['error']) && $_GET['error'] == 'self_action'): ?>
    <script>Swal.fire({icon: 'error', title: 'Error', text: 'No puedes modificar tu propia cuenta.'});</script>
<?php endif; ?>

<!-- ======================= -->
<!-- VISTA DESKTOP (Tabla)   -->
<!-- ======================= -->
<div class="hidden md:block bg-white shadow-lg rounded-lg overflow-hidden border border-gray-100">
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
                        <div class="flex justify-center space-x-2">
                            <!-- Botones Desktop -->
                            <?php if($user['is_suspended']): ?>
                                <a href="index.php?action=suspend_user&id=<?php echo $user['id']; ?>" class="confirm-action text-green-600 border border-green-200 bg-green-50 px-2 py-1 rounded text-xs font-semibold hover:bg-green-100" data-title="¿Reactivar?" data-text="El usuario volverá a tener acceso." data-icon="question" data-btn-text="Reactivar" data-btn-color="#10b981"><i class="fas fa-unlock"></i></a>
                            <?php else: ?>
                                <a href="index.php?action=suspend_user&id=<?php echo $user['id']; ?>" class="confirm-action text-yellow-600 border border-yellow-200 bg-yellow-50 px-2 py-1 rounded text-xs font-semibold hover:bg-yellow-100" data-title="¿Suspender?" data-text="Se bloqueará el acceso." data-icon="warning" data-btn-text="Suspender" data-btn-color="#d97706"><i class="fas fa-ban"></i></a>
                            <?php endif; ?>
                            <a href="index.php?action=delete_user&id=<?php echo $user['id']; ?>" class="confirm-action text-red-600 border border-red-200 bg-red-50 px-2 py-1 rounded text-xs font-semibold hover:bg-red-100" data-title="¿Eliminar?" data-text="Irreversible." data-icon="error" data-btn-text="Eliminar" data-btn-color="#ef4444"><i class="fas fa-trash"></i></a>
                        </div>
                    <?php else: ?>
                        <span class="text-gray-400 text-xs">--</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- ======================= -->
<!-- VISTA MÓVIL (Tarjetas)  -->
<!-- ======================= -->
<div class="md:hidden space-y-4">
    <?php foreach($users as $user): ?>
    <div class="mobile-card bg-white p-4 rounded-lg shadow-sm border border-gray-200 relative overflow-hidden <?php echo $user['is_suspended'] ? 'bg-red-50 border-red-200' : ''; ?>">
        <div class="flex justify-between items-start mb-3">
            <div class="flex flex-col">
                <span class="font-bold text-lg text-gray-800 flex items-center">
                    <?php echo htmlspecialchars($user['username']); ?>
                    <?php if($user['id'] == $_SESSION['user_id']) echo '<span class="ml-2 text-xs text-blue-500 bg-blue-50 px-2 py-0.5 rounded-full">Tú</span>'; ?>
                </span>
                <span class="text-xs text-gray-500">ID: #<?php echo $user['id']; ?></span>
            </div>
            <span class="<?php echo $user['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800'; ?> px-2 py-1 rounded text-xs font-bold uppercase">
                <?php echo $user['role']; ?>
            </span>
        </div>

        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
            <!-- Estado -->
            <div>
                <?php if($user['is_suspended']): ?>
                    <span class="text-red-600 font-bold text-sm flex items-center"><i class="fas fa-ban mr-2"></i> Suspendido</span>
                <?php else: ?>
                    <span class="text-green-600 font-bold text-sm flex items-center"><i class="fas fa-check mr-2"></i> Activo</span>
                <?php endif; ?>
            </div>

            <!-- Acciones Móvil (Botones Grandes) -->
            <?php if($user['id'] != $_SESSION['user_id']): ?>
                <div class="flex gap-2">
                    <?php if($user['is_suspended']): ?>
                        <a href="index.php?action=suspend_user&id=<?php echo $user['id']; ?>" 
                           class="confirm-action bg-green-100 text-green-700 p-2 rounded hover:bg-green-200 transition"
                           data-title="¿Reactivar?" data-text="El usuario volverá a tener acceso." data-icon="question" data-btn-text="Reactivar" data-btn-color="#10b981">
                           <i class="fas fa-unlock"></i>
                        </a>
                    <?php else: ?>
                        <a href="index.php?action=suspend_user&id=<?php echo $user['id']; ?>" 
                           class="confirm-action bg-yellow-100 text-yellow-700 p-2 rounded hover:bg-yellow-200 transition"
                           data-title="¿Suspender?" data-text="Se bloqueará el acceso." data-icon="warning" data-btn-text="Suspender" data-btn-color="#d97706">
                           <i class="fas fa-ban"></i>
                        </a>
                    <?php endif; ?>
                    
                    <a href="index.php?action=delete_user&id=<?php echo $user['id']; ?>" 
                       class="confirm-action bg-red-100 text-red-700 p-2 rounded hover:bg-red-200 transition"
                       data-title="¿Eliminar?" data-text="Esta acción es irreversible." data-icon="error" data-btn-text="Eliminar" data-btn-color="#ef4444">
                       <i class="fas fa-trash"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include 'views/layout/footer.php'; ?>
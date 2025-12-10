<?php include 'views/layout/header.php'; ?>
<div class="max-w-md mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Registrar Nuevo Usuario</h2>
    
    <?php if(isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=create_user">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre de Usuario</label>
            <input type="text" name="username" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Rol</label>
            <select name="role" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-blue-500">
                <option value="user">Usuario (Soporte/Cliente)</option>
                <option value="admin">Administrador</option>
            </select>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none">
                Guardar Usuario
            </button>
            <a href="index.php?action=users" class="text-gray-500 hover:text-gray-700">Cancelar</a>
        </div>
    </form>
</div>
<?php include 'views/layout/footer.php'; ?>
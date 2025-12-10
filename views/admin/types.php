<?php include 'views/layout/header.php'; ?>
<div class="flex gap-6">
    <!-- Lista -->
    <div class="w-2/3">
        <h2 class="text-2xl font-bold mb-4">Tipos de Tickets Existentes</h2>
        <div class="bg-white shadow rounded">
            <ul>
                <?php foreach($types as $type): ?>
                <li class="border-b px-4 py-3 flex justify-between items-center">
                    <span><?php echo $type['name']; ?></span>
                    <form method="POST" onsubmit="return confirm('¿Eliminar?');">
                        <input type="hidden" name="delete_id" value="<?php echo $type['id']; ?>">
                        <button type="submit" class="text-red-500 hover:text-red-700">Eliminar</button>
                    </form>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <!-- Crear -->
    <div class="w-1/3">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-xl font-bold mb-4">Agregar Nuevo Tipo</h3>
            <form method="POST">
                <input type="text" name="name" placeholder="Nombre (ej. Redes)" class="w-full border p-2 mb-4 rounded" required>
                <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded">Agregar</button>
            </form>
        </div>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>
<?php include 'views/layout/header.php'; ?>
<div class="flex gap-6 flex-col md:flex-row">
    <!-- Lista -->
    <div class="w-full md:w-2/3">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Tipos de Tickets</h2>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden border border-gray-100">
            <ul class="divide-y divide-gray-100">
                <?php foreach($types as $type): ?>
                <li class="px-6 py-4 flex justify-between items-center hover:bg-gray-50 transition">
                    <span class="font-medium text-gray-700"><?php echo $type['name']; ?></span>
                    <form method="POST">
                        <input type="hidden" name="delete_id" value="<?php echo $type['id']; ?>">
                        <button type="submit" 
                                class="confirm-action text-red-500 hover:text-red-700 font-semibold text-sm flex items-center transition"
                                data-title="¿Eliminar Categoría?"
                                data-text="Esta categoría dejará de estar disponible para nuevos tickets."
                                data-icon="warning"
                                data-btn-text="Sí, eliminar"
                                data-btn-color="#ef4444">
                            <i class="fas fa-trash-alt mr-2"></i> Eliminar
                        </button>
                    </form>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    
    <!-- Crear -->
    <div class="w-full md:w-1/3">
        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-blue-600">
            <h3 class="text-xl font-bold mb-4 text-gray-800">Agregar Nuevo Tipo</h3>
            <form method="POST">
                <label class="block text-gray-600 text-sm font-bold mb-2">Nombre de la Categoría</label>
                <input type="text" name="name" placeholder="Ej. Acceso VPN" class="w-full border p-3 mb-4 rounded-lg focus:outline-none focus:border-blue-500 bg-gray-50" required>
                <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-lg font-bold hover:bg-blue-700 transition shadow">
                    <i class="fas fa-plus mr-2"></i> Agregar
                </button>
            </form>
        </div>
    </div>
</div>
<?php include 'views/layout/footer.php'; ?>
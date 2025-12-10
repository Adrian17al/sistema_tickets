<?php include 'views/layout/header.php'; ?>
<div class="max-w-2xl mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Crear Nuevo Ticket</h2>
    <form method="POST" action="index.php?action=create_ticket">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Asunto</label>
            <input type="text" name="subject" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:shadow-outline" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Incidencia</label>
            <select name="type_id" class="w-full border rounded px-3 py-2 text-gray-700 focus:outline-none focus:shadow-outline">
                <?php foreach($types as $type): ?>
                    <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
            <textarea name="description" class="w-full border rounded px-3 py-2 text-gray-700 h-32" required></textarea>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Crear Ticket
            </button>
            <a href="index.php?action=tickets" class="text-gray-500 hover:text-gray-700">Cancelar</a>
        </div>
    </form>
</div>
<?php include 'views/layout/footer.php'; ?>
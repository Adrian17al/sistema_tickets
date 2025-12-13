<?php include 'views/layout/header.php'; ?>
<div class="max-w-md mx-auto bg-white p-8 rounded shadow mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center">Iniciar Sesión</h2>
    <?php if(isset($error)) echo "<p class='text-red-500 mb-4'>$error</p>"; ?>
    <form method="POST" action="index.php?action=login">
        <div class="mb-4">
            <label class="block mb-1">Usuario</label>
            <input type="text" name="username" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1">Contraseña</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Entrar</button>
    </form>
</div>
<?php include 'views/layout/footer.php'; ?>
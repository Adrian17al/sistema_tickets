<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Tickets MVC</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
<nav class="bg-blue-600 text-white p-4 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
        <a href="index.php?action=dashboard" class="text-xl font-bold"><i class="fas fa-ticket-alt mr-2"></i>SupportDesk</a>
        <div>
            <?php if(isset($_SESSION['user_id'])): ?>
                <span class="mr-4">Hola, <?php echo $_SESSION['username']; ?> (<?php echo $_SESSION['role']; ?>)</span>
                <a href="index.php?action=tickets" class="hover:underline mr-3">Tickets</a>
                <?php if($_SESSION['role'] === 'admin'): ?>
                    <a href="index.php?action=types" class="hover:underline mr-3">Configuración</a>
                <?php endif; ?>
                <a href="index.php?action=logout" class="bg-red-500 hover:bg-red-700 px-3 py-1 rounded">Salir</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<div class="container mx-auto p-6">

<?php
require 'database.php';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-gray-800 p-4 text-white flex justify-between">
        <div class="text-2xl font-bold">Pokémon Webshop</div>
        <div>
            <a href="index.php" class="mr-4">Home</a>
            <a href="register.php" class="text-blue-500">Registreren</a>
        </div>
    </nav>

    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Inloggen</h2>
        <form action="login-process.php" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700" for="email">E-mailadres</label>
                <input type="text" name="email" placeholder="Email" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Wachtwoord</label>
                <input type="password" name="password" placeholder="Wachtwoord" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <button type="submit" name="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg">Inloggen</button>
        </form>
        <p class="mt-4 text-center">Nog geen account? <a href="register.php" class="text-blue-500">Registreer hier</a></p>
    </div>
</body>
</html>

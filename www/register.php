<?php
session_start();
require 'database.php';
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-gray-800 p-4 text-white flex justify-between">
        <div class="text-2xl font-bold">Pokémon Webshop</div>
        <div>
            <a href="index.php" class="mr-4">Home</a>
            <a href="login.php" class="text-blue-500">Inloggen</a>
        </div>
    </nav>

    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Registreren</h2>
        <form action="register-process.php" method="post">
            <div class="mb-4">
                <label class="block text-gray-700" for="name">Naam:</label>
                <input type="text" id="name" name="name" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
          
            <div class="mb-4">
                <label class="block text-gray-700" for="email">Email:</label>
                <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="password">Wachtwoord:</label>
                <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="address">Adres:</label>
                <input type="text" id="address" name="address" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
           
         
           
            

            <input type="submit" value="Registreren" class="w-full bg-blue-600 text-white py-2 rounded-lg">
        </form>

        <p class="mt-4 text-center">Al een account? <a href="login.php" class="text-blue-500">Inloggen hier</a></p>
    </div>
</body>

</html>

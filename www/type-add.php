<?php
session_start();
require 'database.php';

// Controleer of de admin is ingelogd
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Als het formulier wordt ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];  // Naam van het type
    $image = null;

    // Controleer of er een afbeelding is geüpload
   

    // Voeg het type toe aan de database
    $stmt = $pdo->prepare("INSERT INTO Types (type_name) VALUES (?)");
    $stmt->execute([$name]);

    // Redirect terug naar types overzicht
    header("Location: types.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Nieuw Type Toevoegen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-gray-800 p-4 text-white flex justify-between">
        <div class="text-2xl font-bold">Pokémon Webshop - Admin</div>

        <div class="relative group">
            <button class="mr-4 px-4 py-2 bg-gray-700 rounded-lg hover:bg-gray-600">Kaarten ▾</button>
            <div class="absolute hidden bg-white text-black rounded-lg shadow-lg group-hover:block">
                <a href="cards.php" class="block px-4 py-2 hover:bg-gray-200">Bekijken</a>
                <a href="add-card.php" class="block px-4 py-2 hover:bg-gray-200">Toevoegen</a>
            </div>
        </div>

        <div class="relative group">
            <button class="mr-4 px-4 py-2 bg-gray-700 rounded-lg hover:bg-gray-600">Klanten ▾</button>
            <div class="absolute hidden bg-white text-black rounded-lg shadow-lg group-hover:block">
                <a href="customers.php" class="block px-4 py-2 hover:bg-gray-200">Bekijken</a>
                <a href="customer-add.php" class="block px-4 py-2 hover:bg-gray-200">Toevoegen</a>
            </div>
        </div>

        <div class="relative group">
            <button class="mr-4 px-4 py-2 bg-gray-700 rounded-lg hover:bg-gray-600">Types ▾</button>
            <div class="absolute hidden bg-white text-black rounded-lg shadow-lg group-hover:block">
                <a href="types.php" class="block px-4 py-2 hover:bg-gray-200">Bekijken</a>
                <a href="type-add.php" class="block px-4 py-2 hover:bg-gray-200">Toevoegen</a>
            </div>
        </div>

        <div>
            <a href="admin-dashboard.php" class="mr-4">Dashboard</a>
            <a href="logout.php" class="text-red-500">Uitloggen</a>
        </div>
    </nav>

    <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Nieuw Type Toevoegen</h2>
        <form method="POST" enctype="multipart/form-data">
            <label class="block mb-2">Type Naam:</label>
            <input type="text" name="name" class="w-full p-2 border rounded-lg mb-4" required>

            

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Toevoegen</button>
        </form>
        <a href="types.php" class="text-red-500 block mt-4">Annuleren</a>
    </div>
</body>

</html>

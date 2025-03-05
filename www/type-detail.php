<?php
require 'database.php';

// Haal de type-ID op uit de URL
$type_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Debugging: Controleer of de ID correct wordt opgehaald
if ($type_id === 0) {
    die("Geen geldig type-ID opgegeven.");
}

// Bereid en voer de SQL-query uit om het type op te halen
$stmt = $pdo->prepare("SELECT * FROM Types WHERE type_id = ?");
$stmt->execute([$type_id]);
$type = $stmt->fetch();

// Controleer of het type is gevonden
if (!$type) {
    die("Type niet gevonden. Controleer ID: " . $type_id);
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $type['type_name']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-gray-800 p-4 text-white flex justify-between">
        <div class="text-2xl font-bold">Pokémon Webshop - Admin</div>

        <div class="relative group">
            <button class="mr-4 px-4 py-2 bg-gray-700 rounded-lg hover:bg-gray-600">Types ▾</button>
            <div class="absolute hidden bg-white text-black rounded-lg shadow-lg group-hover:block">
                <a href="types.php" class="block px-4 py-2 hover:bg-gray-200">Bekijken</a>
                <a href="add-type.php" class="block px-4 py-2 hover:bg-gray-200">Toevoegen</a>
            </div>
        </div>

        <div class="relative group">
            <button class="mr-4 px-4 py-2 bg-gray-700 rounded-lg hover:bg-gray-600">Kaarten ▾</button>
            <div class="absolute hidden bg-white text-black rounded-lg shadow-lg group-hover:block">
                <a href="cards.php" class="block px-4 py-2 hover:bg-gray-200">Bekijken</a>
                <a href="add-card.php" class="block px-4 py-2 hover:bg-gray-200">Toevoegen</a>
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

    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <!-- Type-afbeelding (optioneel) -->
        <!-- Als je een afbeelding hebt voor types, kun je deze hier toevoegen. -->
        

        <!-- Type details -->
        <h2 class="text-3xl font-bold mt-4"><?php echo $type['type_name']; ?></h2>
        <h2 class="text-3xl font-bold mt-4"><?php echo $type['type_id']; ?></h2>

        <!-- Beschrijving van het type -->
       
    </div>

</body>

</html>

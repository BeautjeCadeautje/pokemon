<?php
session_start();

// Controleer of de gebruiker is ingelogd als admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require 'database.php';

// Haal admingegevens op
$stmt = $pdo->prepare("SELECT * FROM Admins WHERE admin_id = ?");
$stmt->execute([$_SESSION['admin_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Zoekfunctionaliteit
$search = isset($_GET['search']) ? $_GET['search'] : '';
$type_filter = isset($_GET['type']) ? $_GET['type'] : '';

// Bouw de SQL-query met zoek- en typefilter
$query = "SELECT * FROM Cards WHERE name LIKE ?";
$params = ["%$search%"];

if ($type_filter) {
    $query .= " AND type = ?";
    $params[] = $type_filter;
}

// Voer de query uit
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verkrijg de beschikbare types voor de filter
$stmt = $pdo->query("SELECT Cards.*, Types.type_name FROM Cards 
                      LEFT JOIN Types ON Cards.type_id = Types.type_id
                      ORDER BY Cards.name ASC");
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Pokémon Webshop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <!-- Navigatiebalk -->
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



    <!-- Welkomstbericht -->
    <div class="bg-white shadow-md rounded-lg p-6 max-w-7xl mx-auto mt-8">
        <h2 class="text-3xl font-bold">Welkom, <?php echo htmlspecialchars($user['name']); ?>!</h2>
        <p class="text-gray-600 mt-2">Je bent ingelogd als <?php echo htmlspecialchars($user['email']); ?>.</p>
    </div>



</body>

</html>
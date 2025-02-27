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
$type_stmt = $pdo->prepare("SELECT DISTINCT type FROM Cards");
$type_stmt->execute();
$types = $type_stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <div>
            <a href="cards.php" class="mr-4">Kaarten</a>
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

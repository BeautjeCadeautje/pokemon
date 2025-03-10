<?php
require 'database.php';

// Haal de kaart-ID op uit de URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Debugging: Controleer of de ID correct wordt opgehaald
if ($id === 0) {
    die("Geen geldige kaart-ID opgegeven.");
}

// Bereid en voer de SQL-query uit om de kaart op te halen
$stmt = $pdo->prepare("
    SELECT Cards.*, Types.type_name 
    FROM Cards 
    LEFT JOIN Types ON Cards.type_id = Types.type_id 
    WHERE card_id = ?
");
$stmt->execute([$id]);
$card = $stmt->fetch();


// Controleer of de kaart is gevonden
if (!$card) {
    die("Kaart niet gevonden. Controleer ID: " . $id);
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $card['name']; ?></title>
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


    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <!-- Kaartafbeelding -->
        <img src="/images/<?php echo $card['afbeelding']; ?>" alt="<?php echo $card['name']; ?>" class="w-80 h-90 object-cover">

        <!-- Kaartdetails -->
        <h2 class="text-3xl font-bold mt-4"><?php echo $card['name']; ?></h2>
        <p class="text-gray-600">Type: <?php echo htmlspecialchars($card['type_name'] ?? 'Onbekend'); ?></p>

        <p class="text-gray-600">Rarity: <?php echo $card['rarity'] ?? 'Onbekend'; ?></p>
        <p class="mt-4">Prijs: €<?php echo number_format($card['price'], 2); ?></p>

        <!-- Beschrijving -->
        <div class="mt-6">
            <h3 class="text-2xl font-semibold">Beschrijving</h3>
            <p class="text-gray-700 mt-2"><?php echo nl2br(htmlspecialchars($card['description'])); ?></p>
        </div>
    </div>

</body>

</html>
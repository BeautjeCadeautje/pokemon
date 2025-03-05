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

// Verkrijg de beschikbare types voor de filter
$stmt = $pdo->query("SELECT * FROM Types ORDER BY type_name ASC");
$types = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Bouw de SQL-query met zoek- en typefilter
$query = "SELECT Cards.*, Types.type_name FROM Cards 
          LEFT JOIN Types ON Cards.type_id = Types.type_id
          WHERE Cards.name LIKE ?";
$params = ["%$search%"];

if ($type_filter) {
    $query .= " AND Types.type_id = ?";
    $params[] = $type_filter;
}

$query .= " ORDER BY Cards.name ASC";

// Voer de query uit
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pokémon Kaarten</title>
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

    <div class="max-w-7xl mx-auto py-12">
        <!-- Zoek- en filtersectie -->
        <form action="cards.php" method="GET" class="flex items-center mb-6">
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Zoek naar een kaart..." class="px-4 py-2 border rounded-l-lg">
            <select name="type" class="px-4 py-2 border rounded-r-lg ml-4">
                <option value="">Alle types</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?php echo $type['type_id']; ?>" <?php echo $type['type_id'] == $type_filter ? 'selected' : ''; ?>>
                        <?php echo ucfirst($type['type_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="ml-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Zoeken</button>
        </form>

        <h2 class="text-3xl font-bold mb-6">Beheer Pokémon Kaarten</h2>

        <!-- Tabelweergave -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-3">ID</th>
                        <th class="border p-3">Afbeelding</th>
                        <th class="border p-3">Naam</th>
                        <th class="border p-3">Type</th>
                        <th class="border p-3">Rarity</th>
                        <th class="border p-3">Prijs</th>
                        <th class="border p-3">Beschrijving</th>
                        <th class="border p-3">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cards)): ?>
                        <?php foreach ($cards as $card): ?>
                            <tr class="hover:bg-gray-100">
                                <td class="border p-3 text-center"><?php echo $card['card_id']; ?></td>
                                <td class="border p-3 text-center">
                                    <img src="/images/<?php echo htmlspecialchars($card['afbeelding']); ?>" alt="Afbeelding" class="h-16 mx-auto">
                                </td>
                                <td class="border p-3 text-center"><?php echo htmlspecialchars($card['name']); ?></td>
                                <td class="border p-3 text-center"><?php echo htmlspecialchars($card['type_name']); ?></td>
                                <td class="border p-3 text-center"><?php echo htmlspecialchars($card['rarity']); ?></td>
                                <td class="border p-3 text-center"><?php echo htmlspecialchars($card['price']); ?></td>
                                <td class="border p-3 text-center"><?php echo htmlspecialchars($card['description']); ?></td>
                                <td class="border p-3 text-center">
                                    <a href="card-detail.php?id=<?php echo $card['card_id']; ?>" class="text-blue-600 hover:text-blue-800 mr-2">Bekijken</a>
                                    <a href="edit-card.php?id=<?php echo $card['card_id']; ?>" class="text-blue-600 hover:text-blue-800 mr-2">Bewerken</a>
                                    <a href="delete-card.php?id=<?php echo $card['card_id']; ?>" class="text-red-600 hover:text-red-800" onclick="return confirm('Weet je zeker dat je deze kaart wilt verwijderen?');">Verwijderen</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="border p-3 text-center text-gray-600">Geen kaarten gevonden.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

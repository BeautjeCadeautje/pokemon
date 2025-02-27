<?php
session_start();
require 'database.php';

// Zoekfunctionaliteit
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Filter op type
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
    <title>Pokémon Webshop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <nav class="bg-gray-800 p-4 text-white flex justify-between">
        <div class="text-2xl font-bold">Pokémon Webshop</div>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="mr-4">Dashboard</a>
                <a href="logout.php" class="text-red-500">Uitloggen</a>
            <?php else: ?>
                <a href="login.php" class="mr-4">Inloggen</a>
                <a href="register.php" class="text-blue-500">Registreren</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Zoek- en filtersectie -->
    <div class="max-w-7xl mx-auto py-12">
        <form action="index.php" method="GET" class="flex items-center mb-6">
            <!-- Zoekbalk -->
            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Zoek naar een kaart..." class="px-4 py-2 border rounded-l-lg">
            
            <!-- Type filter -->
            <select name="type" class="px-4 py-2 border rounded-r-lg ml-4">
                <option value="">Alle types</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?php echo $type['type']; ?>" <?php echo $type['type'] === $type_filter ? 'selected' : ''; ?>>
                        <?php echo ucfirst($type['type']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <button type="submit" class="ml-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Zoeken</button>
        </form>

        <h2 class="text-3xl font-bold mb-6">Alle Pokémon Kaarten</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($cards as $card): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <!-- Afbeelding ophalen en weergeven op de pagina -->
                    <img src="/images/<?php echo $card['afbeelding']; ?>" class="w-100 h-100 object-cover">

                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2"><?php echo $card['name']; ?></h3>
                        <p class="text-gray-600 mb-4">Type: <?php echo $card['type']; ?></p>
                        <a href="card-detail.php?id=<?php echo $card['card_id']; ?>" class="text-blue-600 hover:text-blue-800">Meer informatie →</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>

</html>

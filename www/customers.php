<?php
session_start();
require 'database.php';

// Controleer of de admin is ingelogd
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Klanten ophalen
$stmt = $pdo->query("SELECT * FROM Customers ORDER BY created_at DESC");
$customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verwijderen van een klant
if (isset($_GET['delete'])) {
    $delete_stmt = $pdo->prepare("DELETE FROM Customers WHERE customer_id = ?");
    $delete_stmt->execute([$_GET['delete']]);
    header("Location: customers.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klanten Overzicht</title>
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
    <h2 class="text-2xl font-bold mb-4">Klanten Overzicht</h2>
    <div class="bg-white p-6 rounded-lg shadow-md">
        <table class="w-full border-collapse border border-gray-300">
            <tr class="bg-gray-200">
                <th class="border p-3">ID</th>
                <th class="border p-3">Naam</th>
                <th class="border p-3">E-mail</th>
                <th class="border p-3">Adres</th>
                <th class="border p-3">Aangemaakt op</th>
                <th class="border p-3">Acties</th>
            </tr>
            <?php foreach ($customers as $customer): ?>
                <tr class="hover:bg-gray-100">
                    <td class="border p-3 text-center"><?= htmlspecialchars($customer['customer_id']) ?></td>
                    <td class="border p-3 text-center"><?= htmlspecialchars($customer['name']) ?></td>
                    <td class="border p-3 text-center"><?= htmlspecialchars($customer['email']) ?></td>
                    <td class="border p-3 text-center"><?= htmlspecialchars($customer['address']) ?></td>
                    <td class="border p-3 text-center"><?= htmlspecialchars($customer['created_at']) ?></td>
                    <td class="border p-3 text-center">
                        <a href="customer-detail.php?id=<?= $customer['customer_id'] ?>" class="text-blue-500">Details</a> |
                        <a href="customer-edit.php?id=<?= $customer['customer_id'] ?>" class="text-yellow-500">Bewerken</a> |
                        <a href="customer-delete.php?id=<?= $customer['customer_id'] ?>" class="text-red-500" onclick="return confirm('Weet je zeker dat je deze klant wilt verwijderen?')">Verwijderen</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>
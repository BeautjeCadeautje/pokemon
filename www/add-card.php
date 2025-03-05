<?php
session_start();
require 'database.php';

// Controleer of de admin is ingelogd
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Haal alle beschikbare types op uit de database
$type_stmt = $pdo->query("SELECT * FROM Types");
$types = $type_stmt->fetchAll(PDO::FETCH_ASSOC);

// Als het formulier wordt ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $type_id = $_POST['type_id']; // Haal het type_id op vanuit de dropdown
    $rarity = $_POST['rarity'];
    $price = floatval($_POST['price']); // Zet de waarde om naar een float
    $description = $_POST['description'];
    $image = null;

    // Controleer of er een afbeelding is geüpload
    if (!empty($_FILES['afbeelding']['name'])) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["afbeelding"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Controleer of het bestand een afbeelding is
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            move_uploaded_file($_FILES["afbeelding"]["tmp_name"], $target_file);
            $image = $_FILES["afbeelding"]["name"]; // Sla de bestandsnaam op in de database
        } else {
            echo "Ongeldig bestandstype. Alleen JPG, PNG en GIF toegestaan.";
            exit;
        }
    }

    // Voeg de kaart toe aan de database
    $stmt = $pdo->prepare("INSERT INTO Cards (name, type_id, rarity, price, description, afbeelding) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $type_id, $rarity, $price, $description, $image]);

    // Redirect terug naar kaarten overzicht
    header("Location: cards.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pokémon Kaarten toevoegen</title>
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
        <h2 class="text-2xl font-bold mb-4">Nieuwe Kaart Toevoegen</h2>
        <form method="POST" enctype="multipart/form-data">
            <label class="block mb-2">Naam:</label>
            <input type="text" name="name" class="w-full p-2 border rounded-lg mb-4" required>

            <label class="block mb-2">Type:</label>
            <select name="type_id" class="w-full p-2 border rounded-lg mb-4" required>
                <?php foreach ($types as $type): ?>
                    <option value="<?php echo $type['type_id']; ?>">
                        <?php echo htmlspecialchars($type['type_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label class="block mb-2">Rarity:</label>
            <input type="text" name="rarity" class="w-full p-2 border rounded-lg mb-4" required>

            <label class="block mb-2">Prijs:</label>
            <input type="text" name="price" class="w-full p-2 border rounded-lg mb-4" required>

            <label class="block mb-2">Beschrijving:</label>
            <textarea name="description" class="w-full p-2 border rounded-lg mb-4" required></textarea>

            <label class="block mb-2">Afbeelding:</label>
            <input type="file" name="afbeelding" class="w-full p-2 border rounded-lg mb-4">

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Toevoegen</button>
        </form>
        <a href="cards.php" class="text-red-500 block mt-4">Annuleren</a>
    </div>
</body>

</html>

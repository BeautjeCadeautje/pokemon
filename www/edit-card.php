<?php
session_start();
require 'database.php';

// Controleer of de admin is ingelogd
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Controleer of een ID is meegegeven
if (!isset($_GET['id'])) {
    die("Geen kaart ID opgegeven.");
}

$card_id = $_GET['id'];

// Haal de kaartgegevens op
$stmt = $pdo->prepare("
    SELECT Cards.*, Types.type_name 
    FROM Cards 
    LEFT JOIN Types ON Cards.type_id = Types.type_id 
    WHERE card_id = ?
");
$stmt->execute([$card_id]);
$card = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$card) {
    die("Kaart niet gevonden.");
}

// Haal alle beschikbare types op
$type_stmt = $pdo->query("SELECT * FROM Types");
$types = $type_stmt->fetchAll(PDO::FETCH_ASSOC);

// Verwerken van updates
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $type_id = $_POST['type_id'];
    $rarity = $_POST['rarity'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $card['afbeelding']; // Behoudt de oude afbeelding als er geen nieuwe is geüpload

    // Controleer of er een nieuwe afbeelding is geüpload
    if (!empty($_FILES['afbeelding']['name'])) {
        $target_dir = "images/";
        $target_file = $target_dir . basename($_FILES["afbeelding"]["name"]);
        move_uploaded_file($_FILES["afbeelding"]["tmp_name"], $target_file);
        $image = $_FILES["afbeelding"]["name"]; // Sla de nieuwe afbeelding op
    }

    // Update de kaart in de database
    $update_stmt = $pdo->prepare("UPDATE Cards SET name = ?, type_id = ?, rarity = ?, price = ?, description = ?, afbeelding = ? WHERE card_id = ?");
    $update_stmt->execute([$name, $type_id, $rarity, $price, $description, $image, $card_id]);

    header("Location: cards.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaart Bewerken</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Kaart Bewerken</h2>
        <form method="POST" enctype="multipart/form-data">
            <label class="block mb-2">Naam:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($card['name']); ?>" class="w-full p-2 border rounded-lg mb-4" required>

            <label class="block mb-2">Type:</label>
            <select name="type_id" class="w-full p-2 border rounded-lg mb-4" required>
                <?php foreach ($types as $type): ?>
                    <option value="<?php echo $type['type_id']; ?>" 
                        <?php echo ($type['type_id'] == $card['type_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($type['type_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label class="block mb-2">Rarity:</label>
            <input type="text" name="rarity" value="<?php echo htmlspecialchars($card['rarity'] ?? 'Onbekend'); ?>" class="w-full p-2 border rounded-lg mb-4" required>

            <label class="block mb-2">Prijs:</label>
            <input type="text" name="price" value="<?php echo htmlspecialchars($card['price']); ?>" class="w-full p-2 border rounded-lg mb-4" required>

            <label class="block mb-2">Beschrijving:</label>
            <textarea name="description" class="w-full p-2 border rounded-lg mb-4" required><?php echo htmlspecialchars($card['description']); ?></textarea>

            <label class="block mb-2">Afbeelding:</label>
            <input type="file" name="afbeelding" class="w-full p-2 border rounded-lg mb-4">
            <img src="/images/<?php echo htmlspecialchars($card['afbeelding']); ?>" class="h-32 mt-2">

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Opslaan</button>
        </form>
        <a href="cards.php" class="text-red-500 block mt-4">Annuleren</a>
    </div>
</body>

</html>

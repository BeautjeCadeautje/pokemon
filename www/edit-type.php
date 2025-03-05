<?php
session_start();
require 'database.php';

// Controleer of de admin is ingelogd
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Controleer of een type ID is meegegeven
if (!isset($_GET['id'])) {
    die("Geen type ID opgegeven.");
}

$type_id = $_GET['id'];

// Haal de typegegevens op
$stmt = $pdo->prepare("SELECT * FROM Types WHERE type_id = ?");
$stmt->execute([$type_id]);
$type = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$type) {
    die("Type niet gevonden.");
}

// Verwerken van updates
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type_name = $_POST['type_name'];
   



    // Update het type in de database
    $update_stmt = $pdo->prepare("UPDATE Types SET type_name = ? WHERE type_id = ?");
    $update_stmt->execute([$type_name, $type_id]);

    header("Location: types.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Type Bewerken</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Type Bewerken</h2>
        <form method="POST" enctype="multipart/form-data">
            <label class="block mb-2">Naam van Type:</label>
            <input type="text" name="type_name" value="<?php echo htmlspecialchars($type['type_name']); ?>" class="w-full p-2 border rounded-lg mb-4" required>


            
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Opslaan</button>
        </form>
        <a href="types.php" class="text-red-500 block mt-4">Annuleren</a>
    </div>
</body>

</html>

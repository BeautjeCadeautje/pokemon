<?php
session_start();
require 'database.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Geen klant ID opgegeven.");
}

$customer_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM Customers WHERE customer_id = ?");
$stmt->execute([$_GET['id']]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$customer) {
    die("Klant niet gevonden.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    

    // Update de klant in de database
    $update_stmt = $pdo->prepare("UPDATE Customers SET name = ?, email = ?, address = ? WHERE customer_id = ?");
    $update_stmt->execute([$name, $email, $address, $customer_id]);


    header("Location: customers.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klant Bewerken</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">Klant Bewerken</h2>
        <form method="POST" enctype="multipart/form-data">
            <label class="block mb-2">Naam:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($customer['name']); ?>" class="w-full p-2 border rounded-lg mb-4" required>

            <label class="block mb-2">Email:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" class="w-full p-2 border rounded-lg mb-4" required>

            <label class="block mb-2">Adres:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>" class="w-full p-2 border rounded-lg mb-4" required>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Opslaan</button>
        </form>
        <a href="customers.php" class="text-red-500 block mt-4">Annuleren</a>
    </div>
</body>

</html>

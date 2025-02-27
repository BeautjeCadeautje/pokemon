<?php
session_start(); // Zorg ervoor dat session_start bovenaan staat

// Controleer of de gebruiker is ingelogd, zo niet, stuur ze naar de login pagina
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

include 'database.php';

// Voer de query uit om de gegevens van de ingelogde gebruiker op te halen
$stmt = $pdo->prepare("SELECT * FROM Customers WHERE customer_id = ?");
$stmt->execute([$_SESSION['customer_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-3xl font-bold">Welkom, <?php echo htmlspecialchars($user['name']); ?>!</h2>
        <p class="mt-4">Je bent ingelogd als <?php echo htmlspecialchars($user['email']); ?>.</p>

        <a href="logout.php" class="text-red-600 mt-4 inline-block">Uitloggen</a>
    </div>
</body>

</html>

<?php
session_start();
require 'database.php';  // Dit includeert de verbinding via $pdo

// Debugging: Controleer of $pdo daadwerkelijk gedefinieerd is
if (!$pdo) {
    die("Database connection failed!");
}

// Check if all required fields are filled
$required_fields = ['name', 'email', 'password', 'address'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        echo "Please fill in all fields.";
        exit;
    }
}

// Sanitize inputs
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];  // Geen hashing hier, dat gebeurt later
$name = htmlspecialchars($_POST['name']);
$address = htmlspecialchars($_POST['address']);

// Verkrijg de huidige datum en tijd
$created_at = date('Y-m-d H:i:s');

try {
    // Begin een transactie
    $pdo->beginTransaction();

    // Insert user into `Customers` table, inclusief created_at
    $stmt = $pdo->prepare("INSERT INTO Customers (email, password, name, address, created_at) 
                            VALUES (:email, :password, :name, :address, :created_at)");
    $stmt->execute([
        ':email' => $email,
        ':password' => password_hash($password, PASSWORD_DEFAULT),  // Hash wachtwoord
        ':name' => $name,
        ':address' => $address,
        ':created_at' => $created_at,  // Voeg created_at toe
    ]);

    // Commit de transactie
    $pdo->commit();

    // Redirect naar de loginpagina
    header("Location: login.php");
    exit;

} catch (PDOException $e) {
    // Als er iets misgaat, rol de transactie terug
    $pdo->rollBack();
    echo "Something went wrong: " . $e->getMessage();
}
?>

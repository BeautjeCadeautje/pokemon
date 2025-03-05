<?php
session_start();
require 'database.php';

// Controleer of de admin is ingelogd
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Controleer of er een ID is meegegeven
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Haal klantgegevens op
    $select_stmt = $pdo->prepare("SELECT * FROM Customers WHERE customer_id = ?");
    $select_stmt->execute([$customer_id]);
    $customer = $select_stmt->fetch();

    if ($customer) {
        // Verwijder de klant uit de database
        $delete_stmt = $pdo->prepare("DELETE FROM Customers WHERE customer_id = ?");
        $delete_stmt->execute([$customer_id]);
    }
}

// Redirect terug naar customers.php na verwijderen
header("Location: customers.php");
exit;

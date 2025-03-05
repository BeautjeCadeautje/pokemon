<?php
session_start();
require 'database.php';

// Controleer of de admin is ingelogd
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Controleer of er een ID is meegegeven en of het een geldig numeriek type_id is
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $type_id = $_GET['id'];

    // Haal het type op uit de database om te controleren of het bestaat
    $stmt = $pdo->prepare("SELECT * FROM Types WHERE type_id = ?");
    $stmt->execute([$type_id]);
    $type = $stmt->fetch(PDO::FETCH_ASSOC);

    // Controleer of het type bestaat
    if ($type) {
        // Verwijder het type uit de database
        $delete_stmt = $pdo->prepare("DELETE FROM Types WHERE type_id = ?");
        $delete_stmt->execute([$type_id]);
    }
}

// Redirect terug naar types.php na verwijderen
header("Location: types.php");
exit;
?>

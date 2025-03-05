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
    $card_id = $_GET['id'];

    // Haal de afbeelding op voordat we de kaart verwijderen
    $stmt = $pdo->prepare("SELECT afbeelding FROM Cards WHERE card_id = ?");
    $stmt->execute([$card_id]);
    $card = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($card) {
        // Verwijder de kaart uit de database
        $delete_stmt = $pdo->prepare("DELETE FROM Cards WHERE card_id = ?");
        $delete_stmt->execute([$card_id]);

        // Verwijder de afbeelding uit de map als deze bestaat
        if (!empty($card['afbeelding']) && file_exists("images/" . $card['afbeelding'])) {
            unlink("images/" . $card['afbeelding']);
        }
    }
}

// Redirect terug naar cards.php na verwijderen
header("Location: cards.php");
exit;
?>

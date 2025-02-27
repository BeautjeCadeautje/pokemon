<?php
$host = 'mariadb';
$dbname = 'pokemon_db';
$user = 'root';
$pass = 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Databaseverbinding mislukt: " . $e->getMessage());
}
?>
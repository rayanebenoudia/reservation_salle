<?php
$host = 'gabriel-sempere.students-laplateforme.io';
$dbname = 'gabriel-sempere_room-reservation';
$username = 'gmr';
$password = 'laplateforme.io'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
<?php
// Login à la base de donnée avec des variables, faciles a modifié si changement de mot de passe ou de db
$host = 'gabriel-sempere.students-laplateforme.io';
$dbname = 'gabriel-sempere_room-reservation';
$username = 'gmr';
$password = 'laplateforme.io';     

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // On utilise PDO pour se connecter à la base de donnée
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>
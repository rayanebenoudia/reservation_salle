<?php
session_start();
require_once "db.php";

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Accès refusé : vous n'avez pas les droits pour supprimer.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        // 3. Requête de suppression
        $sql = "DELETE FROM event WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        // 4. Redirection vers le planning avec un message de succès (optionnel)
        header("Location: schedule.php?");
        exit();

    } catch (PDOException $e) {
        die("Erreur lors de la suppression : " . $e->getMessage());
    }
} else {
    // Si on arrive sur cette page sans passer par le bouton
    header("Location: schedule.php");
    exit();
}
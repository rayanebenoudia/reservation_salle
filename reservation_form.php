<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["id"])) {
    echo "Vous devez être connecté";
    exit;
}

if (isset($_POST["submit"])) {

    $title = $_POST["title"];
    $description = $_POST["description"];

    $date = $_POST["date"];
    $heure_debut = $_POST["heure_debut"];
    $heure_fin = $_POST["heure_fin"];

    $start_time = $date . " " . $heure_debut . ":00";
    $end_time = $date . " " . $heure_fin . ":00";

    $sql = "INSERT INTO event (event_title, description, start_time, end_time, creator_id)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $title,
        $description,
        $start_time,
        $end_time,
        $_SESSION["id"]
    ]);

    header("Location: schedule.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Créer une réservation</title>
</head>

<body>

    <h1>Créer une réservation</h1>

    <form method="post">

        <label>Titre</label><br>
        <input type="text" name="title" required><br><br>

        <label>Description</label><br>
        <textarea name="description"></textarea><br><br>

        <label>Date</label><br>
        <input type="date" name="date" required><br><br>

        <label>Heure de début</label><br>
        <input type="time" name="heure_debut" required><br><br>

        <label>Heure de fin</label><br>
        <input type="time" name="heure_fin" required><br><br>

        <input type="submit" name="submit" value="Réserver">

    </form>

    <br>
    <a href="schedule.php">Retour au planning</a>

</body>

</html>
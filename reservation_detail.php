<?php
require_once "db.php";

if (!isset($_GET["id"])) {
    echo "Aucune réservation sélectionnée";
    exit;
}

$id = $_GET["id"];

$sql = "
SELECT event.*, user.username
FROM event
JOIN user ON event.creator_id = user.id
WHERE event.id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    echo "Réservation introuvable";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détail réservation</title>
</head>
<body>

<h1>Détail de la réservation</h1>
<?php
$timezone = new DateTimeZone('Europe/Paris');
$start = new DateTime($event["start_time"], $timezone);
$end = new DateTime($event["end_time"], $timezone);

$formatter = new IntlDateFormatter(
    'fr_FR',
    IntlDateFormatter::FULL,
    IntlDateFormatter::NONE,
    'Europe/Paris',
    IntlDateFormatter::GREGORIAN,
    "dd EEEE MMMM HH:mm"
);
?>
<p><b>Créateur :</b> <?php echo $event["username"]; ?></p>
<p><b>Titre :</b> <?php echo $event["event_title"]; ?></p>  
<p><b>Description :</b> <?php echo $event["description"]; ?></p>

<p><b>Début :</b> <?php echo ucfirst($formatter->format($start)); ?></p>
<p><b>Fin :</b> <?php echo ucfirst($formatter->format($end)); ?></p>

<br>
<a href="schedule.php">Retour au planning</a>

</body>
</html>
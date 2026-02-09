<?php
require_once "db.php";
session_start();

$week_offset = isset($_GET['week']) ? (int)$_GET['week'] : 0;

// On calcule le timestamp du lundi de la semaine
$monday_ts = strtotime("monday this week +" . $week_offset . " weeks");
$start_week = date("Y-m-d 00:00:00", $monday_ts);
$end_week = date("Y-m-d 23:59:59", strtotime("+4 days", $monday_ts));

$sql = "
SELECT event.*, user.username
FROM event
JOIN user ON event.creator_id = user.id
WHERE event.start_time >= ? AND event.start_time <= ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$start_week, $end_week]);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];
$days_fr = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Planning</title>
</head>
<body>

<h1>Planning de la salle</h1>

<div>
    <a href="?week=<?php echo $week_offset - 1; ?>">Précédent</a>
    <b>Semaine du <?php echo date('d/m/Y', $monday_ts); ?></b>
    <a href="?week=<?php echo $week_offset + 1; ?>">Suivant</a>
    <br><br>
    <a href="schedule.php">Aujourd'hui</a>
</div>

<table border="1">
<tr>
    <th>Heure</th>
    <?php for($i = 0; $i < 5; $i++) {
        $day_date = date('d/m', strtotime("+$i days", $monday_ts));
        echo "<th>$days_fr[$i] $day_date</th>";
    } ?>
</tr>

<?php
for ($h = 8; $h < 19; $h++) {
    echo "<tr>";
    echo "<td>$h h - ".($h+1)." h</td>";

    for ($i = 0; $i < 5; $i++) {
        $current_day = $days[$i];
        $booked = false;

        foreach ($events as $event) {
            $e_day = date("l", strtotime($event["start_time"]));
            $e_hour = (int)date("H", strtotime($event["start_time"]));

            if ($e_day == $current_day && $e_hour == $h) {
                echo "<td>";
                echo "<a href='reservation_detail.php?id=".$event["id"]."'>";
                echo htmlspecialchars($event["event_title"])."<br>".htmlspecialchars($event["username"]);
                echo "</a>";
                echo "</td>";
                $booked = true;
                break;
            }
        }

        if (!$booked) {
            echo "<td>Libre</td>";
        }
    }
    echo "</tr>";
}
?>
</table>

<br>
<a href="reservation_form.php">Réserver</a>

</body>
</html>
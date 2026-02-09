<?php
require_once "db.php";

// récupérer toutes les réservations avec le username
$sql = "
SELECT event.*, user.username
FROM event
JOIN user ON event.creator_id = user.id
";
$stmt = $pdo->query($sql);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// jours affichés
$jours = [
    "Monday" => "Lundi",
    "Tuesday" => "Mardi",
    "Wednesday" => "Mercredi",
    "Thursday" => "Jeudi",
    "Friday" => "Vendredi"
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Planning</title>
</head>
<body>
<header class="header">
        
        <a href ="index.php" class ="btn">Accueil</a>
        <a href="reservation_detail.php" class="btn">Ma reservation</a>
        <a href="deconnexion.php" class="btn"> deconnexion</a>
       
        
  
    </header>
<div class ="planning">
<h1>Planning de la salle</h1>

<table border="1">
<tr>
    <th>Heure</th>
    <?php foreach ($jours as $jour) echo "<th>$jour</th>"; ?>
</tr>

<?php
for ($heure = 8; $heure < 19; $heure++) {

    echo "<tr>";
    echo "<td>$heure h - ".($heure+1)." h</td>";

    foreach ($jours as $jour_en => $jour_fr) {

        $reserve = false;

        foreach ($events as $event) {
            $jour_event = date("l", strtotime($event["start_time"]));
            $heure_event = date("H", strtotime($event["start_time"]));

            if ($jour_event == $jour_en && $heure_event == $heure) {
                echo "<td>";
                echo "<a href='reservation_detail.php?id=".$event["id"]."'>";
                echo $event["event_title"]."<br>".$event["username"];
                echo "</a>";
                echo "</td>";
                $reserve = true;
                break;
            }
        }

        if ($reserve == false) {
            echo "<td>Libre</td>";
        }
    }

    echo "</tr>";
}
?>
</table>

<br>
<a href="reservation_form.php">Creer une reservation</a>
</div>

  
</body>


</html>

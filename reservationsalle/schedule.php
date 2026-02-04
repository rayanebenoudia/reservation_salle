<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Planning de la salle</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 10px;
        }
        a {
            display: block;
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body>

<h1>Planning de la semaine</h1>

<table>
    <tr>
        <th>Heures</th>
        <th>Lundi</th>
        <th>Mardi</th>
        <th>Mercredi</th>
        <th>Jeudi</th>
        <th>Vendredi</th>
    </tr>

    <?php
    for ($hour = 8; $hour < 19; $hour++) {
        echo "<tr>";
        echo "<td>$hour h - " . ($hour + 1) . " h</td>";

        for ($day = 1; $day <= 5; $day++) {
            echo "<td>";
            echo "<a href='reservation-form.php'>Créneau libre</a>";
            echo "</td>";
        }

        echo "</tr>";
    }
    ?>
</table>

</body>
</html>

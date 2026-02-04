<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer une réservation</title>
</head>
<body>

<h1>Nouvelle réservation</h1>

<form>
    <label>Titre de l'événement</label><br>
    <input type="text" name="title"><br><br>

    <label>Description</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Date et heure de début</label><br>
    <input type="datetime-local" name="start"><br><br>

    <label>Date et heure de fin</label><br>
    <input type="datetime-local" name="end"><br><br>

    <button type="submit">Réserver</button>
</form>

</body>
</html>

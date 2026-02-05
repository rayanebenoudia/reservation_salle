<?php
require_once "db.php";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>

<h1>Inscription</h1>

<form method="POST">
    <label>Nom d'utilisateur</label><br>
    <input type="text" name="username"><br><br>

    <label>Mot de passe</label><br>
    <input type="password" name="password"><br><br>

    <label>Confirmer mot de passe</label><br>
    <input type="password" name="confirm_password"><br><br>

    <button type="submit">S'inscrire</button>
</form>

</body>
</html>

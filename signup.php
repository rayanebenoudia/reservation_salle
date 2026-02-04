<?php
require_once 'db.php';

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']); 
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($username) && !empty($password) && !empty($confirm_password)) {
        if ($password === $confirm_password) {
            $check = $pdo->prepare("SELECT id FROM user WHERE username = ?");
            $check->execute([$username]);

            if ($check->rowCount() === 0) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insert = $pdo->prepare("INSERT INTO user (username, password) VALUES (?, ?)");

                if ($insert->execute([$username, $hashed_password])) {
                    echo "<span>Inscription réussie !</span>";
                } else {
                    echo "Erreur lors de l'insertion en base.";
                }
            } else {
                echo "Ce username est déjà utilisé.";
            }
        } else {
            echo "Les mots de passe ne correspondent pas.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>

    <h1>Inscription</h1>


<main>
    <form method="post">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Mot de passe</label>
        <input type="password" name="password" required>

        <label>Confirmer le mot de passe</label>
        <input type="password" name="confirm_password" required>

        <input type="submit" name="submit" value="S'inscrire">

    </form>

    <p>
            <a href="signin.php">Se connecter ?</a>
        </p>
</main>

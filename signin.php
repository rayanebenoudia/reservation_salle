<?php
require_once 'db.php';
session_start();

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $motdepasse = $_POST['password'];

    if (!empty($username) && !empty($motdepasse)) {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($motdepasse, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                echo "<span>Connexion réussie !</span>";
            } else {
                echo "<span>Mot de passe incorrect.</span>";
            }
        } else {
            echo "<span>Utilisateur introuvable</span>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>


    <h1>Connexion</h1>


<main>

    <form method="post">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>

        <input type="submit" name="submit" value="Se connecter">

        <p class="account">
            Pas de compte ? <a href="inscription.php">S'inscrire</a>
        </p>
    </form>
</main>

</body>
</html>

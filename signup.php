<?php
require_once 'db.php';

$message = "";

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']); 
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (!empty($username) && !empty($password) && !empty($confirm_password)) {
        if (strlen($password) < 8) {
            $message = "Le mot de passe doit faire au moins 8 caractères.";
        } elseif ($password === $confirm_password) {
            $check = $pdo->prepare("SELECT id FROM user WHERE username = ?");
            $check->execute([$username]);

            if ($check->rowCount() === 0) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insert = $pdo->prepare("INSERT INTO user (username, password) VALUES (?, ?)");

                if ($insert->execute([$username, $hashed_password])) {
                    $message = "<span style='color:green'>Inscription réussie ! <a href='signin.php'>Connectez-vous</a></span>";
                } else {
                    $message = "Erreur lors de l'inscription.";
                }
            } else {
                $message = "Ce username est déjà utilisé.";
            }
        } else {
            $message = "Les mots de passe ne correspondent pas.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Inscription</h1>
    <main>
        <?php if($message) echo "<p>$message</p>"; ?>
        <form method="post">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Mot de passe</label>
            <input type="password" name="password" placeholder="8 caractère minimum" required>

            <label>Confirmer le mot de passe</label>
            <input type="password" name="confirm_password" required>

            <input type="submit" name="submit" value="S'inscrire">
        </form>
        <p><a href="signin.php">Se connecter ?</a></p>
    </main>
</body>
</html>
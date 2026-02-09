<?php
require_once 'db.php';
// Sécurisation des cookies de session
ini_set('session.cookie_httponly', 1);
session_start();

$error = "";

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $motdepasse = $_POST['password'];

    if (!empty($username) && !empty($motdepasse)) {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($motdepasse, $user['password'])) {
            // Protection contre la fixation de session
            session_regenerate_id(true);
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: profil.php");
            exit();
        } else {
            // Message générique pour la sécurité
            $error = "Identifiants incorrects.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
   <header class="header">
        
        <a href ="index.php" class ="btn">Accueil</a>
        <a href="reservation_detail.php" class="btn">Ma reservation</a>
        <a href="signup.php" class="btn">s'inscrire</a>
        <nav class="navbar">
        <a href="signin.php" class="btn"> se connecter </a>
        </nav>
       
        
  
    </header>
    
    <main>
        <?php if($error) echo "<p style='color:red'>$error</p>"; ?>
        <form method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" name="submit" value="Se connecter">
            <p><a href="signup.php">S'inscrire ?</a></p>
        </form>
    </main>
    <footer class="footer"></footer>
</body>
</html>
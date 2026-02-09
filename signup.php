<?php
require_once "db.php";
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <header class="header">
        
        <a href ="index.php" class ="btn">Accueil</a>
        <a href="reservation_detail.php" class="btn">Ma reservation</a>
        <nav class="navbar">
        <a href="signup.php" class="btn">s'inscrire</a>
        </nav>
        <a href="signin.php" class="btn"> se connecter </a>
       
        
  
    </header>
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
    <footer class="footer"></footer>
</body>
</html>

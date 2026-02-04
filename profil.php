<?php
if(!isset($_SESSION)){
    session_start();
}
require_once 'db.php';

// Vérification connexion
if (!isset($_SESSION['id'])) {
    header('Location: signin.php');
    exit();
}

$id_user = $_SESSION['id'];
$message_status = "";

// Nouveau username
if (isset($_POST['update_username'])) {
    $new_username = htmlspecialchars($_POST['username']);
    
    if (!empty($new_username)) {
        $stmt = $pdo->prepare('UPDATE user SET username = ? WHERE id = ?');
        if ($stmt->execute([$new_username, $id_user])) {
            $_SESSION['username'] = $new_username;
            $message_status = "username mis à jour !";
        }
    }
}

// Nouveau mot de passe
if (isset($_POST['update_password'])) {
    $new_password = $_POST['password'];
    
    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE user SET password = ? WHERE id = ?');
        if ($stmt->execute([$hashed_password, $id_user])) {
            $message_status = "Mot de passe mis à jour !";
        }
    }
}

// Récupérer le username de l'utilisateur
$stmt = $pdo->prepare('SELECT username FROM user WHERE id = ?');
$stmt->execute([$id_user]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    $user['username'] = ""; // Eviter les erreurs si user non trouvé
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    
    <h1>Paramètres du compte</h1>

  
    <?php if(!empty($message_status)) echo "<p class='success'>$message_status</p>"; ?>


       <main>
        <form class="form-profil">
             <p><strong>Nom d'utilisateur</strong></p>

        <?php if (isset($_GET['edit']) && $_GET['edit'] == 'username'): ?>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                <input type="submit" name="update_username" value="Enregistrer">
                <a href="profil.php">Annuler</a>
        <?php else: ?>
            <span><?php echo htmlspecialchars($user['username']); ?></span>
            <button><a href="profil.php?edit=username">Modifier</a></button>
        <?php endif; ?>
             <p><strong>Mot de passe</strong></p>

        <?php if (isset($_GET['edit']) && $_GET['edit'] == 'password'): ?>
                <input type="password" name="password" placeholder="Nouveau mot de passe" required>
                <input type="submit" name="update_password" value="Enregistrer">
                <a href="profil.php">Annuler</a>
        <?php else: ?>
            <span>********</span>
            <button><a href="profil.php?edit=password">Modifier</a></button>
        <?php endif; ?>

    <hr>

    <p><a class="btn-lien" href="deconnexion.php">Se déconnecter</a></p>
        </form>
       </main>
</body>
</html>

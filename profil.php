<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'db.php';

// 1. Sécurité : Si pas connecté, on dégage
if (!isset($_SESSION['id'])) {
    header('Location: signin.php'); 
    exit();
}

$id_user = $_SESSION['id'];
$message_status = "";


// Mise à jour Username
if (isset($_POST['update_username'])) {
    // Nettoyage simple
    $new_username = trim($_POST['username']);

    if (!empty($new_username)) {
        // Vérif double username 
        $check = $pdo->prepare("SELECT id FROM user WHERE username = ? AND id != ?");
        $check->execute([$new_username, $id_user]);
        
        if ($check->rowCount() == 0) {
            $stmt = $pdo->prepare('UPDATE user SET username = ? WHERE id = ?');
            if ($stmt->execute([$new_username, $id_user])) {
                $_SESSION['username'] = $new_username; // On met à jour la session
                $message_status = "Nom d'utilisateur mis à jour !";
                // On redirige pour nettoyer l'URL (enlever ?edit=username)
                header("Location: profil.php");
                exit();
            }
        } else {
            $message_status = "Ce pseudo est déjà pris.";
        }
    }
}

// Mise à jour Password
if (isset($_POST['update_password'])) {
    $new_password = $_POST['password'];

    if (!empty($new_password)) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE user SET password = ? WHERE id = ?');
        if ($stmt->execute([$hashed_password, $id_user])) {
            $message_status = "Mot de passe mis à jour !";
            header("Location: profil.php");
            exit();
        }
    }
}
// Récupération
$stmt = $pdo->prepare('SELECT username FROM user WHERE id = ?');
$stmt->execute([$id_user]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

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

    <?php if (!empty($message_status)): ?>
        <p style="color: green; font-weight: bold;"><?php echo htmlspecialchars($message_status); ?></p>
    <?php endif; ?>

    <main>
        
        <div class="profile-section">
            <p><strong>Nom d'utilisateur</strong></p>

            <?php 
            if (isset($_GET['edit']) && $_GET['edit'] == 'username'): 
            ?>
                <form method="post">
                    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    <input type="submit" name="update_username" value="Enregistrer">
                    <a href="profil.php">Annuler</a>
                </form>

            <?php else: ?>
                <span><?php echo htmlspecialchars($user['username']); ?></span>
                <a href="profil.php?edit=username"><button>Modifier</button></a>
            <?php endif; ?>
        </div>

        <hr>

        <div class="profile-section">
            <p><strong>Mot de passe</strong></p>

            <?php 
            // On vérifie GET
            if (isset($_GET['edit']) && $_GET['edit'] == 'password'): 
            ?>
                <form method="post">
                    <input type="password" name="password" placeholder="Nouveau mot de passe" required>
                    <input type="submit" name="update_password" value="Enregistrer">
                    <a href="profil.php">Annuler</a>
                </form>

            <?php else: ?>
                <span>********</span>
                <a href="profil.php?edit=password"><button>Modifier</button></a>
            <?php endif; ?>
        </div>

        <hr>
        
        <p><a href="deconnexion.php" style="color:red">Se déconnecter</a></p>

    </main>
</body>
</html>
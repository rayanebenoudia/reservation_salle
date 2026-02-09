<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['id'])) {
    header('Location: signin.php'); 
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$id_user = $_SESSION['id'];
$message_status = "";

// Mise à jour Username
if (isset($_POST['update_username'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) die("Erreur CSRF");
    
    $new_username = trim($_POST['username']);
    if (!empty($new_username)) {
        $check = $pdo->prepare("SELECT id FROM user WHERE username = ? AND id != ?");
        $check->execute([$new_username, $id_user]);
        
        if ($check->rowCount() == 0) {
            $stmt = $pdo->prepare('UPDATE user SET username = ? WHERE id = ?');
            if ($stmt->execute([$new_username, $id_user])) {
                $_SESSION['username'] = $new_username;
                header("Location: profil.php?success=1");
                exit();
            }
        } else {
            $message_status = "Ce pseudo est déjà pris.";
        }
    }
}

// Mise à jour Password
if (isset($_POST['update_password'])) {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) die("Erreur CSRF");

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    if (!empty($old_password) && !empty($new_password)) {
        // Vérifier l'ancien mot de passe
        $stmt = $pdo->prepare("SELECT password FROM user WHERE id = ?");
        $stmt->execute([$id_user]);
        $db_pass = $stmt->fetchColumn();

        if (password_verify($old_password, $db_pass)) {
            if (strlen($new_password) >= 8) {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $update = $pdo->prepare("UPDATE user SET password = ? WHERE id = ?");
                $update->execute([$hashed, $id_user]);
                $message_status = "Mot de passe mis à jour !";
            } else {
                $message_status = "Le nouveau mot de passe est trop court.";
            }
        } else {
            $message_status = "L'ancien mot de passe est incorrect.";
        }
    }
}

if (isset($_GET['success'])) $message_status = "Mise à jour réussie !";

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
        <p style=><?php echo htmlspecialchars($message_status); ?></p>
    <?php endif; ?>

    <main>
        <div class="profile-section">
            <p><strong>Nom d'utilisateur</strong></p>
            <?php if (isset($_GET['edit']) && $_GET['edit'] == 'username'): ?>
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
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
            <?php if (isset($_GET['edit']) && $_GET['edit'] == 'password'): ?>
                <form method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="password" name="old_password" placeholder="Ancien mot de passe" required><br><br>
                    <input type="password" name="new_password" placeholder="Nouveau mot de passe" required><br><br>
                    <input type="submit" name="update_password" value="Enregistrer">
                    <a href="profil.php">Annuler</a>
                </form>
            <?php else: ?>
                <span>********</span>
                <a href="profil.php?edit=password"><button>Modifier</button></a>
            <?php endif; ?>
        </div>

        <hr>
        <p><a href="./deconnexion.php" style="color:red">Se déconnecter</a></p>  
    </main> 
</body>
</html>
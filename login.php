<?php
include 'connector.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête pour vérifier les identifiants
    $stmt = $idcon->prepare("SELECT * FROM utilisateurs WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['adherent_id'] = $user['adherent_id'];

        if (!empty($user['adherent_id'])) {
            $adhStmt = $idcon->prepare("SELECT * FROM Adherent WHERE IdA = ?");
            $adhStmt->execute([$user['adherent_id']]);
            $adherent = $adhStmt->fetch();
            if ($adherent) {
                $_SESSION['adherent_nom'] = $adherent['NomA'];
                $_SESSION['adherent_prenom'] = $adherent['PrenomA'];
                $_SESSION['adherent_ville'] = $adherent['Ville'];
            }
        }

        if ($user['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: main_page.php");
        }
        exit();
    } else {
        $error = "Identifiants incorrects";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <div class="card auth-card">
    <h1>Page de connexion</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Se connecter">
    </form>
    </div>
    </div>
</body>
</html>
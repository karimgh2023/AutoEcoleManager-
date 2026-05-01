<?php
require_once __DIR__ . '/../includes/user_guard.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];

    $stmt = $idcon->prepare("UPDATE utilisateurs SET username = ?, password = ? WHERE username = ?");
    $stmt->execute([$new_username, $new_password, $_SESSION['username']]);

    $_SESSION['username'] = $new_username;
    $success = "Profil mis a jour avec succes.";
}

$pageTitle = "Mon profil";
require_once __DIR__ . '/../includes/user_header.php';
?>
<section class="card" style="max-width: 700px;">
    <h1>Mon profil</h1>

    <?php if (isset($success)): ?>
        <div class="success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <div class="card">
        <p><strong>Utilisateur actuel:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <p><strong>Role:</strong> <?php echo $_SESSION['role'] === 'admin' ? 'Administrateur' : 'Utilisateur'; ?></p>
    </div>

    <h2>Modifier mes informations</h2>
    <form method="post">
        <label for="username">Nouveau nom d'utilisateur</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>

        <label for="password">Nouveau mot de passe</label>
        <input type="password" id="password" name="password" placeholder="Entrez votre nouveau mot de passe" required>

        <br><br>
        <input type="submit" value="Mettre a jour mon profil">
    </form>
</section>
<?php require_once __DIR__ . '/../includes/user_footer.php'; ?>

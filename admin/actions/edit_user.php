<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header("Location: /admin/manage_users.php");
    exit();
}

$stmt = $idcon->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();
if (!$user) {
    header("Location: /admin/manage_users.php");
    exit();
}

$adhStmt = $idcon->prepare("SELECT * FROM Adherent ORDER BY NomA, PrenomA");
$adhStmt->execute();
$adherents = $adhStmt->fetchAll();
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string) ($_POST['username'] ?? ''));
    $password = trim((string) ($_POST['password'] ?? ''));
    $role = (string) ($_POST['role'] ?? 'user');
    $adherent_id = ($_POST['adherent_id'] ?? '') !== '' ? (int) $_POST['adherent_id'] : null;

    if ($username === '' || $password === '') {
        $error = "Username et mot de passe sont obligatoires.";
    } elseif (!in_array($role, ['user', 'admin'], true)) {
        $error = "Role invalide.";
    } else {
        $stmt = $idcon->prepare("UPDATE utilisateurs SET username = ?, password = ?, role = ?, adherent_id = ? WHERE id = ?");
        $stmt->execute([$username, $password, $role, $adherent_id, $id]);
        header("Location: /admin/manage_users.php");
        exit();
    }
}

$activePage = 'users';
$pageTitle = 'Modifier un utilisateur';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Edition utilisateur</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="post" class="grid">
        <div>
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($user['password']); ?>" required>
        </div>
        <div>
            <label for="adherent_id">Adherent (optionnel)</label>
            <select id="adherent_id" name="adherent_id">
                <option value="">Aucun</option>
                <?php foreach ($adherents as $a): ?>
                    <option value="<?php echo $a['IdA']; ?>" <?php if ((string) $user['adherent_id'] === (string) $a['IdA']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($a['IdA'] . ' - ' . $a['NomA'] . ' ' . $a['PrenomA']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="role">Role</label>
            <select id="role" name="role">
                <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>Utilisateur</option>
                <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Administrateur</option>
            </select>
        </div>
        <div class="inline-actions">
            <input type="submit" value="Mettre a jour">
            <a href="/admin/manage_users.php">Retour</a>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

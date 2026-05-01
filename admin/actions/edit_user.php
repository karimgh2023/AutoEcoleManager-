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
        try {
            $stmt = $idcon->prepare("UPDATE utilisateurs SET username = ?, password = ?, role = ?, adherent_id = ? WHERE id = ?");
            $stmt->execute([$username, $password, $role, $adherent_id, $id]);
            set_flash('success', "Utilisateur mis a jour avec succes.");
            header("Location: /admin/manage_users.php");
            exit();
        } catch (PDOException $e) {
            $error = "Impossible de mettre a jour l'utilisateur.";
        }
    }
}

$userFormData = [
    'username' => (string) ($_POST['username'] ?? $user['username']),
    'password' => (string) ($_POST['password'] ?? $user['password']),
    'adherent_id' => (string) ($_POST['adherent_id'] ?? ($user['adherent_id'] ?? '')),
    'role' => (string) ($_POST['role'] ?? $user['role']),
];
$submitLabel = 'Mettre a jour';

$activePage = 'users';
$pageTitle = 'Modifier un utilisateur';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Edition utilisateur</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php require __DIR__ . '/partials/user_form.php'; ?>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

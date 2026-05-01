<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

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
            $stmt = $idcon->prepare("INSERT INTO utilisateurs (username, password, role, adherent_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $password, $role, $adherent_id]);
            set_flash('success', "Utilisateur cree avec succes.");
            header("Location: /admin/manage_users.php");
            exit();
        } catch (PDOException $e) {
            $error = "Impossible de creer l'utilisateur.";
        }
    }
}

$userFormData = [
    'username' => (string) ($_POST['username'] ?? ''),
    'password' => (string) ($_POST['password'] ?? ''),
    'adherent_id' => (string) ($_POST['adherent_id'] ?? ''),
    'role' => (string) ($_POST['role'] ?? 'user'),
];
$submitLabel = 'Ajouter';

$activePage = 'users';
$pageTitle = 'Ajouter un utilisateur';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Nouvel utilisateur</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php require __DIR__ . '/partials/user_form.php'; ?>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

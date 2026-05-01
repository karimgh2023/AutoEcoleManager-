<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header("Location: /admin/manage_moniteurs.php");
    exit();
}
$stmt = $idcon->prepare("SELECT * FROM Moniteur WHERE IdM = ?");
$stmt->execute([$id]);
$moniteur = $stmt->fetch();
if (!$moniteur) {
    header("Location: /admin/manage_moniteurs.php");
    exit();
}
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim((string) ($_POST['nom'] ?? ''));
    $prenom = trim((string) ($_POST['prenom'] ?? ''));

    if ($nom === '' || $prenom === '') {
        $error = "Nom et prenom sont obligatoires.";
    } else {
        try {
            $stmt = $idcon->prepare("UPDATE Moniteur SET NomM = ?, PrenomM = ? WHERE IdM = ?");
            $stmt->execute([$nom, $prenom, $id]);
            set_flash('success', "Moniteur mis a jour avec succes.");
            header("Location: /admin/manage_moniteurs.php");
            exit();
        } catch (PDOException $e) {
            $error = "Impossible de mettre a jour le moniteur.";
        }
    }
}

$moniteurFormData = [
    'nom' => (string) ($_POST['nom'] ?? $moniteur['NomM']),
    'prenom' => (string) ($_POST['prenom'] ?? $moniteur['PrenomM']),
];
$submitLabel = 'Mettre a jour';

$activePage = 'moniteurs';
$pageTitle = 'Modifier un moniteur';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Edition moniteur</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php require __DIR__ . '/partials/moniteur_form.php'; ?>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

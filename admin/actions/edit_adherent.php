<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    header("Location: /admin/manage_adherents.php");
    exit();
}
$stmt = $idcon->prepare("SELECT * FROM Adherent WHERE IdA = ?");
$stmt->execute([$id]);
$adherent = $stmt->fetch();
if (!$adherent) {
    header("Location: /admin/manage_adherents.php");
    exit();
}
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim((string) ($_POST['nom'] ?? ''));
    $prenom = trim((string) ($_POST['prenom'] ?? ''));
    $ville = trim((string) ($_POST['ville'] ?? ''));

    if ($nom === '' || $prenom === '' || $ville === '') {
        $error = "Tous les champs sont obligatoires.";
    } else {
        try {
            $stmt = $idcon->prepare("UPDATE Adherent SET NomA = ?, PrenomA = ?, Ville = ? WHERE IdA = ?");
            $stmt->execute([$nom, $prenom, $ville, $id]);
            set_flash('success', "Adherent mis a jour avec succes.");
            header("Location: /admin/manage_adherents.php");
            exit();
        } catch (PDOException $e) {
            $error = "Impossible de mettre a jour l'adherent.";
        }
    }
}

$adherentFormData = [
    'nom' => (string) ($_POST['nom'] ?? $adherent['NomA']),
    'prenom' => (string) ($_POST['prenom'] ?? $adherent['PrenomA']),
    'ville' => (string) ($_POST['ville'] ?? $adherent['Ville']),
];
$submitLabel = 'Mettre a jour';

$activePage = 'adherents';
$pageTitle = 'Modifier un adherent';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Edition adherent</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php require __DIR__ . '/partials/adherent_form.php'; ?>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

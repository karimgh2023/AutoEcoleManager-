<?php
require_once __DIR__ . '/../../includes/admin_guard.php';
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim((string) ($_POST['nom'] ?? ''));
    $prenom = trim((string) ($_POST['prenom'] ?? ''));

    if ($nom === '' || $prenom === '') {
        $error = "Nom et prenom sont obligatoires.";
    } else {
        try {
            $stmt = $idcon->prepare("INSERT INTO Moniteur (NomM, PrenomM) VALUES (?, ?)");
            $stmt->execute([$nom, $prenom]);
            set_flash('success', "Moniteur cree avec succes.");
            header("Location: /admin/manage_moniteurs.php");
            exit();
        } catch (PDOException $e) {
            $error = "Impossible de creer le moniteur.";
        }
    }
}

$moniteurFormData = [
    'nom' => (string) ($_POST['nom'] ?? ''),
    'prenom' => (string) ($_POST['prenom'] ?? ''),
];
$submitLabel = 'Ajouter';

$activePage = 'moniteurs';
$pageTitle = 'Ajouter un moniteur';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Nouveau moniteur</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php require __DIR__ . '/partials/moniteur_form.php'; ?>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

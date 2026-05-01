<?php
require_once __DIR__ . '/../../includes/admin_guard.php';
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim((string) ($_POST['nom'] ?? ''));
    $prenom = trim((string) ($_POST['prenom'] ?? ''));
    $ville = trim((string) ($_POST['ville'] ?? ''));

    if ($nom === '' || $prenom === '' || $ville === '') {
        $error = "Tous les champs sont obligatoires.";
    } else {
        try {
            $stmt = $idcon->prepare("INSERT INTO Adherent (NomA, PrenomA, Ville) VALUES (?, ?, ?)");
            $stmt->execute([$nom, $prenom, $ville]);
            set_flash('success', "Adherent cree avec succes.");
            header("Location: /admin/manage_adherents.php");
            exit();
        } catch (PDOException $e) {
            $error = "Impossible de creer l'adherent.";
        }
    }
}

$adherentFormData = [
    'nom' => (string) ($_POST['nom'] ?? ''),
    'prenom' => (string) ($_POST['prenom'] ?? ''),
    'ville' => (string) ($_POST['ville'] ?? ''),
];
$submitLabel = 'Ajouter';

$activePage = 'adherents';
$pageTitle = 'Ajouter un adherent';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Nouvel adherent</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php require __DIR__ . '/partials/adherent_form.php'; ?>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

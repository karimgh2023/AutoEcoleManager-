<?php
require_once __DIR__ . '/../../includes/admin_guard.php';
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim((string) ($_POST['nom'] ?? ''));
    $prenom = trim((string) ($_POST['prenom'] ?? ''));

    if ($nom === '' || $prenom === '') {
        $error = "Nom et prenom sont obligatoires.";
    } else {
        $stmt = $idcon->prepare("INSERT INTO Moniteur (NomM, PrenomM) VALUES (?, ?)");
        $stmt->execute([$nom, $prenom]);
        header("Location: /admin/manage_moniteurs.php");
        exit();
    }
}

$activePage = 'moniteurs';
$pageTitle = 'Ajouter un moniteur';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Nouveau moniteur</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="post" class="grid">
        <div><label for="nom">Nom</label><input type="text" id="nom" name="nom" required></div>
        <div><label for="prenom">Prenom</label><input type="text" id="prenom" name="prenom" required></div>
        <div class="inline-actions">
            <input type="submit" value="Ajouter">
            <a href="/admin/manage_moniteurs.php">Retour</a>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

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
        $stmt = $idcon->prepare("INSERT INTO Adherent (NomA, PrenomA, Ville) VALUES (?, ?, ?)");
        $stmt->execute([$nom, $prenom, $ville]);
        header("Location: /admin/manage_adherents.php");
        exit();
    }
}

$activePage = 'adherents';
$pageTitle = 'Ajouter un adherent';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Nouvel adherent</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="post" class="grid">
        <div><label for="nom">Nom</label><input type="text" id="nom" name="nom" required></div>
        <div><label for="prenom">Prenom</label><input type="text" id="prenom" name="prenom" required></div>
        <div><label for="ville">Ville</label><input type="text" id="ville" name="ville" required></div>
        <div class="inline-actions">
            <input type="submit" value="Ajouter">
            <a href="/admin/manage_adherents.php">Retour</a>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

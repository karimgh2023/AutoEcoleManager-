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
        $stmt = $idcon->prepare("UPDATE Adherent SET NomA = ?, PrenomA = ?, Ville = ? WHERE IdA = ?");
        $stmt->execute([$nom, $prenom, $ville, $id]);
        header("Location: /admin/manage_adherents.php");
        exit();
    }
}

$activePage = 'adherents';
$pageTitle = 'Modifier un adherent';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Edition adherent</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="post" class="grid">
        <div><label for="nom">Nom</label><input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($adherent['NomA']); ?>" required></div>
        <div><label for="prenom">Prenom</label><input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($adherent['PrenomA']); ?>" required></div>
        <div><label for="ville">Ville</label><input type="text" id="ville" name="ville" value="<?php echo htmlspecialchars($adherent['Ville']); ?>" required></div>
        <div class="inline-actions">
            <input type="submit" value="Mettre a jour">
            <a href="/admin/manage_adherents.php">Retour</a>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

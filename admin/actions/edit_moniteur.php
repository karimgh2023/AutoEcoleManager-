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
        $stmt = $idcon->prepare("UPDATE Moniteur SET NomM = ?, PrenomM = ? WHERE IdM = ?");
        $stmt->execute([$nom, $prenom, $id]);
        header("Location: /admin/manage_moniteurs.php");
        exit();
    }
}

$activePage = 'moniteurs';
$pageTitle = 'Modifier un moniteur';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Edition moniteur</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="post" class="grid">
        <div><label for="nom">Nom</label><input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($moniteur['NomM']); ?>" required></div>
        <div><label for="prenom">Prenom</label><input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($moniteur['PrenomM']); ?>" required></div>
        <div class="inline-actions">
            <input type="submit" value="Mettre a jour">
            <a href="/admin/manage_moniteurs.php">Retour</a>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

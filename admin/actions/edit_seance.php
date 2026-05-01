<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$idm = isset($_GET['idm']) ? (int) $_GET['idm'] : 0;
$ida = isset($_GET['ida']) ? (int) $_GET['ida'] : 0;
$date = (string) ($_GET['date'] ?? '');
if ($idm <= 0 || $ida <= 0 || $date === '') {
    header("Location: /admin/manage_seances.php");
    exit();
}

$stmt = $idcon->prepare("SELECT * FROM Seance WHERE IdM = ? AND IdA = ? AND DateS = ?");
$stmt->execute([$idm, $ida, $date]);
$seance = $stmt->fetch();
if (!$seance) {
    header("Location: /admin/manage_seances.php");
    exit();
}

$stmtM = $idcon->prepare("SELECT * FROM Moniteur");
$stmtM->execute();
$moniteurs = $stmtM->fetchAll();
$stmtA = $idcon->prepare("SELECT * FROM Adherent");
$stmtA->execute();
$adherents = $stmtA->fetchAll();
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idm_new = (int) ($_POST['idm'] ?? 0);
    $ida_new = (int) ($_POST['ida'] ?? 0);
    $date_new = trim((string) ($_POST['date'] ?? ''));
    $heure = trim((string) ($_POST['heure'] ?? ''));
    $nbheures = (int) ($_POST['nbheures'] ?? 0);

    if ($idm_new <= 0 || $ida_new <= 0 || $date_new === '' || $heure === '' || $nbheures <= 0) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $idcon->prepare("UPDATE Seance SET IdM = ?, IdA = ?, DateS = ?, HeureS = ?, NbHeures = ? WHERE IdM = ? AND IdA = ? AND DateS = ?");
        $stmt->execute([$idm_new, $ida_new, $date_new, $heure, $nbheures, $idm, $ida, $date]);
        header("Location: /admin/manage_seances.php");
        exit();
    }
}

$activePage = 'seances';
$pageTitle = 'Modifier une seance';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Edition seance</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="post" class="grid">
        <div><label for="idm">Moniteur</label><select id="idm" name="idm" required><?php foreach ($moniteurs as $m): ?><option value="<?php echo $m['IdM']; ?>" <?php if ((int) $m['IdM'] === (int) $seance['IdM']) echo 'selected'; ?>><?php echo htmlspecialchars($m['NomM'] . ' ' . $m['PrenomM']); ?></option><?php endforeach; ?></select></div>
        <div><label for="ida">Adherent</label><select id="ida" name="ida" required><?php foreach ($adherents as $a): ?><option value="<?php echo $a['IdA']; ?>" <?php if ((int) $a['IdA'] === (int) $seance['IdA']) echo 'selected'; ?>><?php echo htmlspecialchars($a['NomA'] . ' ' . $a['PrenomA']); ?></option><?php endforeach; ?></select></div>
        <div><label for="date">Date</label><input type="date" id="date" name="date" value="<?php echo htmlspecialchars($seance['DateS']); ?>" required></div>
        <div><label for="heure">Heure</label><input type="time" id="heure" name="heure" value="<?php echo htmlspecialchars($seance['HeureS']); ?>" required></div>
        <div><label for="nbheures">Nombre d'heures</label><input type="number" id="nbheures" name="nbheures" min="1" value="<?php echo (int) $seance['NbHeures']; ?>" required></div>
        <div class="inline-actions">
            <input type="submit" value="Mettre a jour">
            <a href="/admin/manage_seances.php">Retour</a>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$stmtM = $idcon->prepare("SELECT * FROM Moniteur");
$stmtM->execute();
$moniteurs = $stmtM->fetchAll();
$stmtA = $idcon->prepare("SELECT * FROM Adherent");
$stmtA->execute();
$adherents = $stmtA->fetchAll();
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idm = (int) ($_POST['idm'] ?? 0);
    $ida = (int) ($_POST['ida'] ?? 0);
    $date = trim((string) ($_POST['date'] ?? ''));
    $heure = trim((string) ($_POST['heure'] ?? ''));
    $nbheures = (int) ($_POST['nbheures'] ?? 0);

    if ($idm <= 0 || $ida <= 0 || $date === '' || $heure === '' || $nbheures <= 0) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $idcon->prepare("INSERT INTO Seance (IdM, IdA, DateS, HeureS, NbHeures) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$idm, $ida, $date, $heure, $nbheures]);
        header("Location: /admin/manage_seances.php");
        exit();
    }
}

$activePage = 'seances';
$pageTitle = 'Ajouter une seance';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Nouvelle seance</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <form method="post" class="grid">
        <div>
            <label for="idm">Moniteur</label>
            <select id="idm" name="idm" required>
                <?php foreach ($moniteurs as $m): ?><option value="<?php echo $m['IdM']; ?>"><?php echo htmlspecialchars($m['NomM'] . ' ' . $m['PrenomM']); ?></option><?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="ida">Adherent</label>
            <select id="ida" name="ida" required>
                <?php foreach ($adherents as $a): ?><option value="<?php echo $a['IdA']; ?>"><?php echo htmlspecialchars($a['NomA'] . ' ' . $a['PrenomA']); ?></option><?php endforeach; ?>
            </select>
        </div>
        <div><label for="date">Date</label><input type="date" id="date" name="date" required></div>
        <div><label for="heure">Heure</label><input type="time" id="heure" name="heure" required></div>
        <div><label for="nbheures">Nombre d'heures</label><input type="number" id="nbheures" name="nbheures" min="1" required></div>
        <div class="inline-actions">
            <input type="submit" value="Ajouter">
            <a href="/admin/manage_seances.php">Retour</a>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

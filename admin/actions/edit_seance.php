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
        try {
            $stmt = $idcon->prepare("UPDATE Seance SET IdM = ?, IdA = ?, DateS = ?, HeureS = ?, NbHeures = ? WHERE IdM = ? AND IdA = ? AND DateS = ?");
            $stmt->execute([$idm_new, $ida_new, $date_new, $heure, $nbheures, $idm, $ida, $date]);
            set_flash('success', "Seance mise a jour avec succes.");
            header("Location: /admin/manage_seances.php");
            exit();
        } catch (PDOException $e) {
            $error = "Impossible de mettre a jour la seance.";
        }
    }
}

$seanceFormData = [
    'idm' => (string) ($_POST['idm'] ?? $seance['IdM']),
    'ida' => (string) ($_POST['ida'] ?? $seance['IdA']),
    'date' => (string) ($_POST['date'] ?? $seance['DateS']),
    'heure' => (string) ($_POST['heure'] ?? $seance['HeureS']),
    'nbheures' => (int) ($_POST['nbheures'] ?? $seance['NbHeures']),
];
$submitLabel = 'Mettre a jour';

$activePage = 'seances';
$pageTitle = 'Modifier une seance';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Edition seance</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php require __DIR__ . '/partials/seance_form.php'; ?>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

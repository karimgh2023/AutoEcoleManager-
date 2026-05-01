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
        try {
            $stmt = $idcon->prepare("INSERT INTO Seance (IdM, IdA, DateS, HeureS, NbHeures) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$idm, $ida, $date, $heure, $nbheures]);
            set_flash('success', "Seance creee avec succes.");
            header("Location: /admin/manage_seances.php");
            exit();
        } catch (PDOException $e) {
            $error = "Impossible de creer la seance.";
        }
    }
}

$seanceFormData = [
    'idm' => (string) ($_POST['idm'] ?? ($moniteurs[0]['IdM'] ?? '')),
    'ida' => (string) ($_POST['ida'] ?? ($adherents[0]['IdA'] ?? '')),
    'date' => (string) ($_POST['date'] ?? ''),
    'heure' => (string) ($_POST['heure'] ?? ''),
    'nbheures' => (int) ($_POST['nbheures'] ?? 1),
];
$submitLabel = 'Ajouter';

$activePage = 'seances';
$pageTitle = 'Ajouter une seance';
require_once __DIR__ . '/../../includes/admin_header.php';
?>
<section class="card">
    <h2>Nouvelle seance</h2>
    <?php if ($error): ?><div class="error"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
    <?php require __DIR__ . '/partials/seance_form.php'; ?>
</section>
<?php require_once __DIR__ . '/../../includes/admin_footer.php'; ?>

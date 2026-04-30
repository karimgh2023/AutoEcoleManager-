<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$idm = $_GET['idm'];
$ida = $_GET['ida'];
$date = $_GET['date'];
$stmt = $idcon->prepare("SELECT * FROM Seance WHERE IdM = ? AND IdA = ? AND DateS = ?");
$stmt->execute([$idm, $ida, $date]);
$seance = $stmt->fetch();

// Fetch moniteurs and adherents
$stmtM = $idcon->prepare("SELECT * FROM Moniteur");
$stmtM->execute();
$moniteurs = $stmtM->fetchAll();

$stmtA = $idcon->prepare("SELECT * FROM Adherent");
$stmtA->execute();
$adherents = $stmtA->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idm_new = $_POST['idm'];
    $ida_new = $_POST['ida'];
    $date_new = $_POST['date'];
    $heure = $_POST['heure'];
    $nbheures = $_POST['nbheures'];

    $stmt = $idcon->prepare("UPDATE Seance SET IdM = ?, IdA = ?, DateS = ?, HeureS = ?, NbHeures = ? WHERE IdM = ? AND IdA = ? AND DateS = ?");
    $stmt->execute([$idm_new, $ida_new, $date_new, $heure, $nbheures, $idm, $ida, $date]);

    header("Location: manage_seances.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Séance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Modifier la Séance</h1>
    <form method="post">
        <label for="idm">Moniteur:</label>
        <select id="idm" name="idm" required>
            <?php foreach ($moniteurs as $m): ?>
                <option value="<?php echo $m['IdM']; ?>" <?php if ($m['IdM'] == $seance['IdM']) echo 'selected'; ?>><?php echo $m['NomM'] . ' ' . $m['PrenomM']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="ida">Adhérent:</label>
        <select id="ida" name="ida" required>
            <?php foreach ($adherents as $a): ?>
                <option value="<?php echo $a['IdA']; ?>" <?php if ($a['IdA'] == $seance['IdA']) echo 'selected'; ?>><?php echo $a['NomA'] . ' ' . $a['PrenomA']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo $seance['DateS']; ?>" required><br><br>
        <label for="heure">Heure:</label>
        <input type="time" id="heure" name="heure" value="<?php echo $seance['HeureS']; ?>" required><br><br>
        <label for="nbheures">Nombre d'Heures:</label>
        <input type="number" id="nbheures" name="nbheures" value="<?php echo $seance['NbHeures']; ?>" required><br><br>
        <input type="submit" value="Mettre à jour">
    </form>
    <a href="manage_seances.php">Retour</a>
    </div>
</body>
</html>
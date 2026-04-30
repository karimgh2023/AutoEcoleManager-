<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch moniteurs and adherents for dropdowns
$stmtM = $idcon->prepare("SELECT * FROM Moniteur");
$stmtM->execute();
$moniteurs = $stmtM->fetchAll();

$stmtA = $idcon->prepare("SELECT * FROM Adherent");
$stmtA->execute();
$adherents = $stmtA->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idm = $_POST['idm'];
    $ida = $_POST['ida'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $nbheures = $_POST['nbheures'];

    $stmt = $idcon->prepare("INSERT INTO Seance (IdM, IdA, DateS, HeureS, NbHeures) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$idm, $ida, $date, $heure, $nbheures]);

    header("Location: manage_seances.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Séance</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Ajouter une Séance</h1>
    <form method="post">
        <label for="idm">Moniteur:</label>
        <select id="idm" name="idm" required>
            <?php foreach ($moniteurs as $m): ?>
                <option value="<?php echo $m['IdM']; ?>"><?php echo $m['NomM'] . ' ' . $m['PrenomM']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="ida">Adhérent:</label>
        <select id="ida" name="ida" required>
            <?php foreach ($adherents as $a): ?>
                <option value="<?php echo $a['IdA']; ?>"><?php echo $a['NomA'] . ' ' . $a['PrenomA']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required><br><br>
        <label for="heure">Heure:</label>
        <input type="time" id="heure" name="heure" required><br><br>
        <label for="nbheures">Nombre d'Heures:</label>
        <input type="number" id="nbheures" name="nbheures" required><br><br>
        <input type="submit" value="Ajouter">
    </form>
    <a href="manage_seances.php">Retour</a>
    </div>
</body>
</html>
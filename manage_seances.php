<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Build search query
$sql = "SELECT s.IdM, s.IdA, m.NomM, m.PrenomM, a.NomA, a.PrenomA, s.DateS, s.HeureS, s.NbHeures FROM Seance s JOIN Moniteur m ON s.IdM = m.IdM JOIN Adherent a ON s.IdA = a.IdA WHERE 1=1";
$params = [];

if (!empty($_GET['date'])) {
    $sql .= " AND s.DateS = ?";
    $params[] = $_GET['date'];
}
if (!empty($_GET['moniteur'])) {
    $sql .= " AND s.IdM = ?";
    $params[] = $_GET['moniteur'];
}
if (!empty($_GET['adherent'])) {
    $sql .= " AND s.IdA = ?";
    $params[] = $_GET['adherent'];
}

$stmt = $idcon->prepare($sql);
$stmt->execute($params);
$seances = $stmt->fetchAll();

// Fetch moniteurs and adherents for search dropdowns
$stmtM = $idcon->prepare("SELECT * FROM Moniteur");
$stmtM->execute();
$moniteurs = $stmtM->fetchAll();

$stmtA = $idcon->prepare("SELECT * FROM Adherent");
$stmtA->execute();
$adherents = $stmtA->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Séances</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-seances">
    <div class="container">
    <h1>Gestion des Séances</h1>
    <a href="add_seance.php">Ajouter une Séance</a><br><br>
    <fieldset>
        <legend>Recherche Multicritère</legend>
        <form method="GET">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>"><br><br>
            <label for="moniteur">Moniteur:</label>
            <select id="moniteur" name="moniteur">
                <option value="">Tous</option>
                <?php foreach ($moniteurs as $m): ?>
                    <option value="<?php echo $m['IdM']; ?>" <?php if (isset($_GET['moniteur']) && $_GET['moniteur'] == $m['IdM']) echo 'selected'; ?>><?php echo $m['NomM'] . ' ' . $m['PrenomM']; ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <label for="adherent">Adhérent:</label>
            <select id="adherent" name="adherent">
                <option value="">Tous</option>
                <?php foreach ($adherents as $a): ?>
                    <option value="<?php echo $a['IdA']; ?>" <?php if (isset($_GET['adherent']) && $_GET['adherent'] == $a['IdA']) echo 'selected'; ?>><?php echo $a['NomA'] . ' ' . $a['PrenomA']; ?></option>
                <?php endforeach; ?>
            </select><br><br>
            <input type="submit" value="Rechercher">
            <a href="manage_seances.php">Réinitialiser</a>
        </form>
    </fieldset><br>
    <table border="1">
        <tr>
            <th>Moniteur</th>
            <th>Adhérent</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Nombre d'Heures</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($seances as $seance): ?>
        <tr>
            <td><?php echo $seance['NomM'] . ' ' . $seance['PrenomM']; ?></td>
            <td><?php echo $seance['NomA'] . ' ' . $seance['PrenomA']; ?></td>
            <td><?php echo $seance['DateS']; ?></td>
            <td><?php echo $seance['HeureS']; ?></td>
            <td><?php echo $seance['NbHeures']; ?></td>
            <td>
                <a href="edit_seance.php?idm=<?php echo $seance['IdM']; ?>&ida=<?php echo $seance['IdA']; ?>&date=<?php echo $seance['DateS']; ?>">Modifier</a> |
                <a href="delete_seance.php?idm=<?php echo $seance['IdM']; ?>&ida=<?php echo $seance['IdA']; ?>&date=<?php echo $seance['DateS']; ?>" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br><a href="admin_dashboard.php">Retour au Dashboard</a>
    </div>
</body>
</html>
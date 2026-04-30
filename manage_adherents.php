<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Build search query
$sql = "SELECT * FROM Adherent WHERE 1=1";
$params = [];

if (!empty($_GET['nom'])) {
    $sql .= " AND NomA LIKE ?";
    $params[] = "%" . $_GET['nom'] . "%";
}
if (!empty($_GET['prenom'])) {
    $sql .= " AND PrenomA LIKE ?";
    $params[] = "%" . $_GET['prenom'] . "%";
}
if (!empty($_GET['ville'])) {
    $sql .= " AND Ville LIKE ?";
    $params[] = "%" . $_GET['ville'] . "%";
}

$stmt = $idcon->prepare($sql);
$stmt->execute($params);
$adherents = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Adhérents</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-adherents">
    <div class="container">
    <h1>Gestion des Adhérents</h1>
    <a href="add_adherent.php">Ajouter un Adhérent</a><br><br>
    <fieldset>
        <legend>Recherche Multicritère</legend>
        <form method="GET">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo isset($_GET['nom']) ? $_GET['nom'] : ''; ?>"><br><br>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo isset($_GET['prenom']) ? $_GET['prenom'] : ''; ?>"><br><br>
            <label for="ville">Ville:</label>
            <input type="text" id="ville" name="ville" value="<?php echo isset($_GET['ville']) ? $_GET['ville'] : ''; ?>"><br><br>
            <input type="submit" value="Rechercher">
            <a href="manage_adherents.php">Réinitialiser</a>
        </form>
    </fieldset><br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Ville</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($adherents as $adherent): ?>
        <tr>
            <td><?php echo $adherent['IdA']; ?></td>
            <td><?php echo $adherent['NomA']; ?></td>
            <td><?php echo $adherent['PrenomA']; ?></td>
            <td><?php echo $adherent['Ville']; ?></td>
            <td>
                <a href="edit_adherent.php?id=<?php echo $adherent['IdA']; ?>">Modifier</a> |
                <a href="delete_adherent.php?id=<?php echo $adherent['IdA']; ?>" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br><a href="admin_dashboard.php">Retour au Dashboard</a>
    </div>
</body>
</html>
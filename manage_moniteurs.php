<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Build search query
$sql = "SELECT * FROM Moniteur WHERE 1=1";
$params = [];

if (!empty($_GET['nom'])) {
    $sql .= " AND NomM LIKE ?";
    $params[] = "%" . $_GET['nom'] . "%";
}
if (!empty($_GET['prenom'])) {
    $sql .= " AND PrenomM LIKE ?";
    $params[] = "%" . $_GET['prenom'] . "%";
}

$stmt = $idcon->prepare($sql);
$stmt->execute($params);
$moniteurs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Moniteurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-moniteurs">
    <div class="container">
    <h1>Gestion des Moniteurs</h1>
    <a href="add_moniteur.php">Ajouter un Moniteur</a><br><br>
    <fieldset>
        <legend>Recherche Multicritère</legend>
        <form method="GET">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?php echo isset($_GET['nom']) ? $_GET['nom'] : ''; ?>"><br><br>
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo isset($_GET['prenom']) ? $_GET['prenom'] : ''; ?>"><br><br>
            <input type="submit" value="Rechercher">
            <a href="manage_moniteurs.php">Réinitialiser</a>
        </form>
    </fieldset><br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($moniteurs as $moniteur): ?>
        <tr>
            <td><?php echo $moniteur['IdM']; ?></td>
            <td><?php echo $moniteur['NomM']; ?></td>
            <td><?php echo $moniteur['PrenomM']; ?></td>
            <td>
                <a href="edit_moniteur.php?id=<?php echo $moniteur['IdM']; ?>">Modifier</a> |
                <a href="delete_moniteur.php?id=<?php echo $moniteur['IdM']; ?>" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br><a href="admin_dashboard.php">Retour au Dashboard</a>
    </div>
</body>
</html>
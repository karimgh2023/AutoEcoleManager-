<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Build search query
$sql = "SELECT u.*, a.NomA as adherent_nom, a.PrenomA as adherent_prenom FROM utilisateurs u LEFT JOIN Adherent a ON u.adherent_id = a.IdA WHERE 1=1";
$params = [];

if (!empty($_GET['username'])) {
    $sql .= " AND username LIKE ?";
    $params[] = "%" . $_GET['username'] . "%";
}
if (!empty($_GET['role'])) {
    $sql .= " AND role = ?";
    $params[] = $_GET['role'];
}

$stmt = $idcon->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-users">
    <div class="container">
    <h1>Gestion des Utilisateurs</h1>
    <a href="add_user.php">Ajouter un Utilisateur</a><br><br>
    <fieldset>
        <legend>Recherche Multicritère</legend>
        <form method="GET">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" value="<?php echo isset($_GET['username']) ? $_GET['username'] : ''; ?>"><br><br>
            <label for="role">Rôle:</label>
            <select id="role" name="role">
                <option value="">Tous</option>
                <option value="user" <?php if (isset($_GET['role']) && $_GET['role'] == 'user') echo 'selected'; ?>>Utilisateur</option>
                <option value="admin" <?php if (isset($_GET['role']) && $_GET['role'] == 'admin') echo 'selected'; ?>>Administrateur</option>
            </select><br><br>
            <input type="submit" value="Rechercher">
            <a href="manage_users.php">Réinitialiser</a>
        </form>
    </fieldset><br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Rôle</th>
            <th>ID Adhérent</th>
            <th>Adhérent</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['role']; ?></td>
            <td><?php echo $user['adherent_id']; ?></td>
            <td><?php echo $user['adherent_nom'] ? $user['adherent_nom'] . ' ' . $user['adherent_prenom'] : '-'; ?></td>
            <td>
                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Modifier</a> |
                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br><a href="admin_dashboard.php">Retour au Dashboard</a>
    </div>
</body>
</html>
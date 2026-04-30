<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Espace Administrateur</h1>
    <p>Bonjour, <?php echo $_SESSION['username']; ?> (Admin)!</p>
    <nav>
        <a href="manage_users.php">Gérer les Utilisateurs</a> |
        <a href="manage_adherents.php">Gérer les Adhérents</a> |
        <a href="manage_moniteurs.php">Gérer les Moniteurs</a> |
        <a href="manage_seances.php">Gérer les Séances</a> |
        <a href="logout.php">Se déconnecter</a>
    </nav>
    <!-- Dashboard avec statistiques, etc. -->
    </div>
</body>
</html>
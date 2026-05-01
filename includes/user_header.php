<?php
$pageTitle = $pageTitle ?? "Espace utilisateur";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <a href="/user/home.php">Accueil</a>
            <a href="/user/next_seances.php">Mes prochaines seances</a>
            <a href="/user/seances_history.php">Historique</a>
            <a href="/user/moniteurs_info.php">Moniteurs</a>
            <a href="/user/stats.php">Mes statistiques</a>
            <a href="/user/profile.php">Mon profil</a>
            <a href="/user/contact_info.php">Contact</a>
            <a href="/logout.php">Se deconnecter</a>
        </nav>

<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Utilisateur</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .dashboard { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .card { border: 1px solid #ddd; padding: 15px; border-radius: 5px; background-color: #f9f9f9; }
        .card h3 { margin-top: 0; color: #333; }
        .card a { color: #0066cc; text-decoration: none; }
        .card a:hover { text-decoration: underline; }
        nav { background-color: #f0f0f0; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #0066cc; }
        nav a:hover { text-decoration: underline; }
        .welcome { background-color: #e3f2fd; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
    <nav>
        <a href="main_page.php">Accueil</a> |
        <a href="next_seances.php">Mes Prochaines Séances</a> |
        <a href="seances_history.php">Historique</a> |
        <a href="moniteurs_info.php">Moniteurs</a> |
        <a href="stats.php">Mes Statistiques</a> |
        <a href="profile.php">Mon Profil</a> |
        <a href="logout.php">Se déconnecter</a>
    </nav>
    
    <div class="welcome">
        <h1>Bienvenue dans l'Espace Utilisateur</h1>
        <p>Bonjour, <strong><?php echo $_SESSION['username']; ?></strong>!</p>
        <?php if (!empty($_SESSION['adherent_id'])): ?>
            <p>Adhérent ID: <strong><?php echo $_SESSION['adherent_id']; ?></strong> | Nom: <strong><?php echo $_SESSION['adherent_prenom'] . ' ' . $_SESSION['adherent_nom']; ?></strong> | Ville: <strong><?php echo $_SESSION['adherent_ville']; ?></strong></p>
        <?php else: ?>
            <p><em>Aucun abonnement adhérent associé pour ce compte.</em></p>
        <?php endif; ?>
        <p>Découvrez votre progression et gérez vos sessions de formation.</p>
    </div>
    
    <div class="dashboard">
        <div class="card">
            <h3>📅 Prochaines Séances</h3>
            <p>Consultez vos prochaines sessions de formation programmées.</p>
            <a href="next_seances.php">Voir mes séances →</a>
        </div>
        
        <div class="card">
            <h3>📊 Mes Statistiques</h3>
            <p>Suivez votre progression : heures de formation, nombre de séances, etc.</p>
            <a href="stats.php">Voir mes statistiques →</a>
        </div>
        
        <div class="card">
            <h3>👨‍🏫 Nos Moniteurs</h3>
            <p>Découvrez nos instructeurs et leurs spécialités.</p>
            <a href="moniteurs_info.php">Voir les moniteurs →</a>
        </div>
        
        <div class="card">
            <h3>⏳ Historique</h3>
            <p>Consultez l'historique de toutes vos séances passées.</p>
            <a href="seances_history.php">Voir l'historique →</a>
        </div>
        
        <div class="card">
            <h3>👤 Mon Profil</h3>
            <p>Mettez à jour vos informations personnelles et votre mot de passe.</p>
            <a href="profile.php">Modifier mon profil →</a>
        </div>
        
        <div class="card">
            <h3>❓ Besoin d'aide?</h3>
            <p>Consultez nos coordonnées et horaires d'ouverture.</p>
            <a href="contact_info.php">Nous contacter →</a>
        </div>
    </div>
</body>
</html>
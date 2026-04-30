<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get all instructors with their session count
$sql = "SELECT m.IdM, m.NomM, m.PrenomM, COUNT(s.IdM) as nb_seances
        FROM Moniteur m
        LEFT JOIN Seance s ON m.IdM = s.IdM
        GROUP BY m.IdM
        ORDER BY m.NomM";

$stmt = $idcon->prepare($sql);
$stmt->execute();
$moniteurs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Moniteurs</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav { background-color: #f0f0f0; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #0066cc; }
        nav a:hover { text-decoration: underline; }
        .moniteur-card { 
            border: 1px solid #ddd; 
            padding: 15px; 
            margin-bottom: 15px; 
            border-radius: 5px; 
            background-color: #f9f9f9;
        }
        .moniteur-card h3 { margin-top: 0; color: #333; }
        .moniteur-card p { margin: 5px 0; }
        .stat { font-weight: bold; color: #0066cc; }
    </style>
</head>
<body>
    <div class="container">
    <nav>
        <a href="main_page.php">← Retour à l'accueil</a>
    </nav>
    
    <h1>Nos Moniteurs</h1>
    <p>Découvrez notre équipe de moniteurs expérimentés.</p>
    
    <?php if (!empty($moniteurs)): ?>
        <?php foreach ($moniteurs as $m): ?>
            <div class="moniteur-card">
                <h3>👨‍🏫 <?php echo $m['NomM'] . ' ' . $m['PrenomM']; ?></h3>
                <p>Séances dirigées : <span class="stat"><?php echo $m['nb_seances']; ?></span></p>
                <p>Expérience : Moniteur qualifié en planche à voile</p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun moniteur disponible pour le moment.</p>
    <?php endif; ?>
    </div>
</body>
</html>
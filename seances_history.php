<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Determine adherent identifier from session
$adherent_id = !empty($_SESSION['adherent_id']) ? $_SESSION['adherent_id'] : null;
$seances = [];

if ($adherent_id) {
    $sql = "SELECT s.IdM, s.IdA, m.NomM, m.PrenomM, a.NomA, a.PrenomA, s.DateS, s.HeureS, s.NbHeures 
            FROM Seance s 
            JOIN Moniteur m ON s.IdM = m.IdM 
            JOIN Adherent a ON s.IdA = a.IdA 
            WHERE s.IdA = ? AND s.DateS < CURDATE() 
            ORDER BY s.DateS DESC, s.HeureS DESC";

    $stmt = $idcon->prepare($sql);
    $stmt->execute([$adherent_id]);
    $seances = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique de mes Séances</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav { background-color: #f0f0f0; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #0066cc; }
        nav a:hover { text-decoration: underline; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #2196F3; color: white; }
        tr:hover { background-color: #f5f5f5; }
        .no-sessions { background-color: #d4edda; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
    <nav>
        <a href="main_page.php">← Retour à l'accueil</a>
    </nav>
    
    <h1>Historique de mes Séances</h1>
    
    <?php if (!empty($seances)): ?>
        <p><strong><?php echo count($seances); ?></strong> séance(s) réalisée(s) | <strong><?php echo array_sum(array_column($seances, 'NbHeures')); ?></strong> heure(s) total</p>
        <table>
            <tr>
                <th>Date</th>
                <th>Heure</th>
                <th>Durée (h)</th>
                <th>Moniteur</th>
            </tr>
            <?php foreach ($seances as $seance): ?>
            <tr>
                <td><?php echo date('d/m/Y', strtotime($seance['DateS'])); ?></td>
                <td><?php echo substr($seance['HeureS'], 0, 5); ?></td>
                <td><?php echo $seance['NbHeures']; ?></td>
                <td><?php echo $seance['NomM'] . ' ' . $seance['PrenomM']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <div class="no-sessions">
            <p>Vous n'avez pas encore suivi de séance. Vos prochaines formations vous seront assignées.</p>
        </div>
    <?php endif; ?>
    </div>
</body>
</html>
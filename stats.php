<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Determine adherent identifier from session
$adherent_id = !empty($_SESSION['adherent_id']) ? $_SESSION['adherent_id'] : null;

$stats = ['total_seances' => 0, 'total_heures' => 0];
$month_stats = ['month_seances' => 0, 'month_heures' => 0];
$progression = [];

if ($adherent_id) {
    // Get user's sessions statistics
    $sql = "SELECT COUNT(*) as total_seances, SUM(s.NbHeures) as total_heures
            FROM Seance s
            WHERE s.IdA = ?";

    $stmt = $idcon->prepare($sql);
    $stmt->execute([$adherent_id]);
    $stats = $stmt->fetch();

    // Get this month sessions
    $sql_month = "SELECT COUNT(*) as month_seances, SUM(s.NbHeures) as month_heures
                 FROM Seance s
                 WHERE s.IdA = ? AND MONTH(s.DateS) = MONTH(CURDATE()) AND YEAR(s.DateS) = YEAR(CURDATE())";

    $stmt_month = $idcon->prepare($sql_month);
    $stmt_month->execute([$adherent_id]);
    $month_stats = $stmt_month->fetch();

    // Get sessions by month (last 6 months)
    $sql_progression = "SELECT DATE_FORMAT(s.DateS, '%Y-%m') as mois, COUNT(*) as nb_seances, SUM(s.NbHeures) as total_heures
                       FROM Seance s
                       WHERE s.IdA = ? AND s.DateS >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                       GROUP BY DATE_FORMAT(s.DateS, '%Y-%m')
                       ORDER BY mois DESC";

    $stmt_prog = $idcon->prepare($sql_progression);
    $stmt_prog->execute([$adherent_id]);
    $progression = $stmt_prog->fetchAll();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Statistiques</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav { background-color: #f0f0f0; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #0066cc; }
        nav a:hover { text-decoration: underline; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 20px 0; }
        .stat-card { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }
        .stat-card.alt { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-card h3 { margin: 0; font-size: 14px; font-weight: normal; opacity: 0.9; }
        .stat-card .number { font-size: 40px; font-weight: bold; margin: 10px 0; }
        .progression-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .progression-table th, .progression-table td { 
            border: 1px solid #ddd; 
            padding: 12px; 
            text-align: left;
        }
        .progression-table th { background-color: #667eea; color: white; }
        .progression-table tr:hover { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <div class="container">
    <nav>
        <a href="main_page.php">← Retour à l'accueil</a>
    </nav>
    
    <h1>Mes Statistiques de Formation</h1>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total de Séances</h3>
            <div class="number"><?php echo $stats['total_seances'] ?? 0; ?></div>
        </div>
        <div class="stat-card alt">
            <h3>Total d'Heures</h3>
            <div class="number"><?php echo $stats['total_heures'] ?? 0; ?>h</div>
        </div>
        <div class="stat-card">
            <h3>Séances ce Mois</h3>
            <div class="number"><?php echo $month_stats['month_seances'] ?? 0; ?></div>
        </div>
        <div class="stat-card alt">
            <h3>Heures ce Mois</h3>
            <div class="number"><?php echo $month_stats['month_heures'] ?? 0; ?>h</div>
        </div>
    </div>
    
    <h2>Progression (6 derniers mois)</h2>
    
    <?php if (!empty($progression)): ?>
        <table class="progression-table">
            <tr>
                <th>Mois</th>
                <th>Séances</th>
                <th>Heures</th>
            </tr>
            <?php foreach ($progression as $row): ?>
            <tr>
                <td><?php echo $row['mois']; ?></td>
                <td><?php echo $row['nb_seances']; ?></td>
                <td><?php echo $row['total_heures']; ?>h</td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucune donnée de progression disponible.</p>
    <?php endif; ?>
    </div>
</body>
</html>
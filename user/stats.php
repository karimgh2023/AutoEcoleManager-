<?php
require_once __DIR__ . '/../includes/user_guard.php';

$adherent_id = !empty($_SESSION['adherent_id']) ? $_SESSION['adherent_id'] : null;
$stats = ['total_seances' => 0, 'total_heures' => 0];
$month_stats = ['month_seances' => 0, 'month_heures' => 0];
$progression = [];

if ($adherent_id) {
    $sql = "SELECT COUNT(*) as total_seances, SUM(s.NbHeures) as total_heures
            FROM Seance s
            WHERE s.IdA = ?";

    $stmt = $idcon->prepare($sql);
    $stmt->execute([$adherent_id]);
    $stats = $stmt->fetch();

    $sql_month = "SELECT COUNT(*) as month_seances, SUM(s.NbHeures) as month_heures
                  FROM Seance s
                  WHERE s.IdA = ? AND MONTH(s.DateS) = MONTH(CURDATE()) AND YEAR(s.DateS) = YEAR(CURDATE())";

    $stmt_month = $idcon->prepare($sql_month);
    $stmt_month->execute([$adherent_id]);
    $month_stats = $stmt_month->fetch();

    $sql_progression = "SELECT DATE_FORMAT(s.DateS, '%Y-%m') as mois, COUNT(*) as nb_seances, SUM(s.NbHeures) as total_heures
                        FROM Seance s
                        WHERE s.IdA = ? AND s.DateS >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                        GROUP BY DATE_FORMAT(s.DateS, '%Y-%m')
                        ORDER BY mois DESC";

    $stmt_prog = $idcon->prepare($sql_progression);
    $stmt_prog->execute([$adherent_id]);
    $progression = $stmt_prog->fetchAll();
}

$pageTitle = "Mes statistiques";
require_once __DIR__ . '/../includes/user_header.php';
?>
<h1>Mes statistiques de formation</h1>

<div class="grid grid-4">
    <article class="stat-card">
        <p>Total de seances</p>
        <strong><?php echo (int) ($stats['total_seances'] ?? 0); ?></strong>
    </article>
    <article class="stat-card">
        <p>Total d'heures</p>
        <strong><?php echo (int) ($stats['total_heures'] ?? 0); ?>h</strong>
    </article>
    <article class="stat-card">
        <p>Seances ce mois</p>
        <strong><?php echo (int) ($month_stats['month_seances'] ?? 0); ?></strong>
    </article>
    <article class="stat-card">
        <p>Heures ce mois</p>
        <strong><?php echo (int) ($month_stats['month_heures'] ?? 0); ?>h</strong>
    </article>
</div>

<section class="card">
    <h2>Progression (6 derniers mois)</h2>
    <?php if (!empty($progression)): ?>
        <table>
            <tr>
                <th>Mois</th>
                <th>Seances</th>
                <th>Heures</th>
            </tr>
            <?php foreach ($progression as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['mois']); ?></td>
                <td><?php echo (int) $row['nb_seances']; ?></td>
                <td><?php echo (int) $row['total_heures']; ?>h</td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucune donnee de progression disponible.</p>
    <?php endif; ?>
</section>
<?php require_once __DIR__ . '/../includes/user_footer.php'; ?>

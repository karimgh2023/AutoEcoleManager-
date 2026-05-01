<?php
require_once __DIR__ . '/../includes/user_guard.php';

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

$pageTitle = "Historique des seances";
require_once __DIR__ . '/../includes/user_header.php';
?>
<h1>Historique de mes seances</h1>

<?php if (!empty($seances)): ?>
    <p><strong><?php echo count($seances); ?></strong> seance(s) realisee(s) | <strong><?php echo array_sum(array_column($seances, 'NbHeures')); ?></strong> heure(s) total</p>
    <table>
        <tr>
            <th>Date</th>
            <th>Heure</th>
            <th>Duree (h)</th>
            <th>Moniteur</th>
        </tr>
        <?php foreach ($seances as $seance): ?>
        <tr>
            <td><?php echo date('d/m/Y', strtotime($seance['DateS'])); ?></td>
            <td><?php echo htmlspecialchars(substr($seance['HeureS'], 0, 5)); ?></td>
            <td><?php echo (int) $seance['NbHeures']; ?></td>
            <td><?php echo htmlspecialchars($seance['NomM'] . ' ' . $seance['PrenomM']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <div class="success">
        <p>Vous n'avez pas encore suivi de seance. Vos prochaines formations vous seront assignees.</p>
    </div>
<?php endif; ?>
<?php require_once __DIR__ . '/../includes/user_footer.php'; ?>

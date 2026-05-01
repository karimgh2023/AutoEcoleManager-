<?php
require_once __DIR__ . '/../includes/user_guard.php';

$adherent_id = !empty($_SESSION['adherent_id']) ? $_SESSION['adherent_id'] : null;
$seances = [];

if ($adherent_id) {
    $sql = "SELECT s.IdM, s.IdA, m.NomM, m.PrenomM, a.NomA, a.PrenomA, s.DateS, s.HeureS, s.NbHeures 
            FROM Seance s 
            JOIN Moniteur m ON s.IdM = m.IdM 
            JOIN Adherent a ON s.IdA = a.IdA 
            WHERE s.IdA = ? AND s.DateS >= CURDATE() 
            ORDER BY s.DateS ASC, s.HeureS ASC";

    $stmt = $idcon->prepare($sql);
    $stmt->execute([$adherent_id]);
    $seances = $stmt->fetchAll();
}

$pageTitle = "Mes prochaines seances";
require_once __DIR__ . '/../includes/user_header.php';
?>
<h1>Mes prochaines seances</h1>

<?php if (!empty($seances)): ?>
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
    <div class="alert">
        <p>Aucune seance programmee pour le moment. Veuillez contacter l'administrateur pour en reserver une.</p>
    </div>
<?php endif; ?>
<?php require_once __DIR__ . '/../includes/user_footer.php'; ?>

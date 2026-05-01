<?php
require_once __DIR__ . '/../includes/user_guard.php';

$sql = "SELECT m.IdM, m.NomM, m.PrenomM, COUNT(s.IdM) as nb_seances
        FROM Moniteur m
        LEFT JOIN Seance s ON m.IdM = s.IdM
        GROUP BY m.IdM
        ORDER BY m.NomM";

$stmt = $idcon->prepare($sql);
$stmt->execute();
$moniteurs = $stmt->fetchAll();

$pageTitle = "Nos moniteurs";
require_once __DIR__ . '/../includes/user_header.php';
?>
<h1>Nos moniteurs</h1>
<p>Decouvrez notre equipe de moniteurs experimentes.</p>

<?php if (!empty($moniteurs)): ?>
    <div class="grid grid-3">
        <?php foreach ($moniteurs as $m): ?>
            <article class="card">
                <h3><?php echo htmlspecialchars($m['NomM'] . ' ' . $m['PrenomM']); ?></h3>
                <p>Seances dirigees: <strong><?php echo (int) $m['nb_seances']; ?></strong></p>
                <p>Moniteur qualifie en planche a voile.</p>
            </article>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Aucun moniteur disponible pour le moment.</p>
<?php endif; ?>
<?php require_once __DIR__ . '/../includes/user_footer.php'; ?>

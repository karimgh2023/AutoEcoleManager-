<?php
require_once __DIR__ . '/../includes/admin_guard.php';

$sql = "SELECT s.IdM, s.IdA, m.NomM, m.PrenomM, a.NomA, a.PrenomA, s.DateS, s.HeureS, s.NbHeures FROM Seance s JOIN Moniteur m ON s.IdM = m.IdM JOIN Adherent a ON s.IdA = a.IdA WHERE 1=1";
$params = [];

if (!empty($_GET['date'])) {
    $sql .= " AND s.DateS = ?";
    $params[] = $_GET['date'];
}
if (!empty($_GET['moniteur'])) {
    $sql .= " AND s.IdM = ?";
    $params[] = $_GET['moniteur'];
}
if (!empty($_GET['adherent'])) {
    $sql .= " AND s.IdA = ?";
    $params[] = $_GET['adherent'];
}

$stmt = $idcon->prepare($sql);
$stmt->execute($params);
$seances = $stmt->fetchAll();

$stmtM = $idcon->prepare("SELECT * FROM Moniteur");
$stmtM->execute();
$moniteurs = $stmtM->fetchAll();

$stmtA = $idcon->prepare("SELECT * FROM Adherent");
$stmtA->execute();
$adherents = $stmtA->fetchAll();

$activePage = 'seances';
$pageTitle = 'Gestion des seances';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<section class="card">
    <div class="section-head">
        <h2>Filtres</h2>
        <a href="/admin/actions/add_seance.php">Ajouter une seance</a>
    </div>
    <form method="GET" class="grid grid-3">
        <div>
            <label for="date">Date</label>
            <input type="date" id="date" name="date" value="<?php echo isset($_GET['date']) ? $_GET['date'] : ''; ?>">
        </div>
        <div>
            <label for="moniteur">Moniteur</label>
            <select id="moniteur" name="moniteur">
                <option value="">Tous</option>
                <?php foreach ($moniteurs as $m): ?>
                    <option value="<?php echo $m['IdM']; ?>" <?php if (isset($_GET['moniteur']) && $_GET['moniteur'] == $m['IdM']) echo 'selected'; ?>><?php echo htmlspecialchars($m['NomM'] . ' ' . $m['PrenomM']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="adherent">Adherent</label>
            <select id="adherent" name="adherent">
                <option value="">Tous</option>
                <?php foreach ($adherents as $a): ?>
                    <option value="<?php echo $a['IdA']; ?>" <?php if (isset($_GET['adherent']) && $_GET['adherent'] == $a['IdA']) echo 'selected'; ?>><?php echo htmlspecialchars($a['NomA'] . ' ' . $a['PrenomA']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="inline-actions">
            <input type="submit" value="Rechercher">
            <a href="/admin/manage_seances.php">Reinitialiser</a>
        </div>
    </form>
</section>

<section class="card">
    <table>
        <tr>
            <th>Moniteur</th>
            <th>Adherent</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Nombre d'heures</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($seances)): ?>
            <?php foreach ($seances as $seance): ?>
            <tr>
                <td><?php echo htmlspecialchars($seance['NomM'] . ' ' . $seance['PrenomM']); ?></td>
                <td><?php echo htmlspecialchars($seance['NomA'] . ' ' . $seance['PrenomA']); ?></td>
                <td><?php echo htmlspecialchars($seance['DateS']); ?></td>
                <td><?php echo htmlspecialchars($seance['HeureS']); ?></td>
                <td><?php echo (int) $seance['NbHeures']; ?></td>
                <td>
                    <a href="/admin/actions/edit_seance.php?idm=<?php echo $seance['IdM']; ?>&ida=<?php echo $seance['IdA']; ?>&date=<?php echo $seance['DateS']; ?>">Modifier</a> |
                    <a href="/admin/actions/delete_seance.php?idm=<?php echo $seance['IdM']; ?>&ida=<?php echo $seance['IdA']; ?>&date=<?php echo $seance['DateS']; ?>" onclick="return confirm('Etes-vous sur ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Aucune seance trouvee.</td>
            </tr>
        <?php endif; ?>
    </table>
</section>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>

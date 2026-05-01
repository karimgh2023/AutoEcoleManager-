<?php
require_once 'includes/admin_guard.php';

// Build search query
$sql = "SELECT * FROM Adherent WHERE 1=1";
$params = [];

if (!empty($_GET['nom'])) {
    $sql .= " AND NomA LIKE ?";
    $params[] = "%" . $_GET['nom'] . "%";
}
if (!empty($_GET['prenom'])) {
    $sql .= " AND PrenomA LIKE ?";
    $params[] = "%" . $_GET['prenom'] . "%";
}
if (!empty($_GET['ville'])) {
    $sql .= " AND Ville LIKE ?";
    $params[] = "%" . $_GET['ville'] . "%";
}

$stmt = $idcon->prepare($sql);
$stmt->execute($params);
$adherents = $stmt->fetchAll();

$activePage = 'adherents';
$pageTitle = 'Gestion des adherents';
require_once 'includes/admin_header.php';
?>
<section class="card">
    <div class="section-head">
        <h2>Filtres</h2>
        <a href="add_adherent.php">Ajouter un adherent</a>
    </div>
    <form method="GET" class="grid grid-3">
        <div>
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?php echo isset($_GET['nom']) ? $_GET['nom'] : ''; ?>">
        </div>
        <div>
            <label for="prenom">Prenom</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo isset($_GET['prenom']) ? $_GET['prenom'] : ''; ?>">
        </div>
        <div>
            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville" value="<?php echo isset($_GET['ville']) ? $_GET['ville'] : ''; ?>">
        </div>
        <div class="inline-actions">
            <input type="submit" value="Rechercher">
            <a href="manage_adherents.php">Reinitialiser</a>
        </div>
    </form>
</section>

<section class="card">
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Ville</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($adherents)): ?>
            <?php foreach ($adherents as $adherent): ?>
            <tr>
                <td><?php echo $adherent['IdA']; ?></td>
                <td><?php echo htmlspecialchars($adherent['NomA']); ?></td>
                <td><?php echo htmlspecialchars($adherent['PrenomA']); ?></td>
                <td><?php echo htmlspecialchars($adherent['Ville']); ?></td>
                <td>
                    <a href="edit_adherent.php?id=<?php echo $adherent['IdA']; ?>">Modifier</a> |
                    <a href="delete_adherent.php?id=<?php echo $adherent['IdA']; ?>" onclick="return confirm('Etes-vous sur ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Aucun adherent trouve.</td>
            </tr>
        <?php endif; ?>
    </table>
</section>
<?php require_once 'includes/admin_footer.php'; ?>
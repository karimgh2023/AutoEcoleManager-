<?php
require_once __DIR__ . '/../includes/admin_guard.php';

$sql = "SELECT * FROM Moniteur WHERE 1=1";
$params = [];

if (!empty($_GET['nom'])) {
    $sql .= " AND NomM LIKE ?";
    $params[] = "%" . $_GET['nom'] . "%";
}
if (!empty($_GET['prenom'])) {
    $sql .= " AND PrenomM LIKE ?";
    $params[] = "%" . $_GET['prenom'] . "%";
}

$stmt = $idcon->prepare($sql);
$stmt->execute($params);
$moniteurs = $stmt->fetchAll();

$activePage = 'moniteurs';
$pageTitle = 'Gestion des moniteurs';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<section class="card">
    <div class="section-head">
        <h2>Filtres</h2>
        <a href="/admin/actions/add_moniteur.php">Ajouter un moniteur</a>
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
        <div class="inline-actions align-end">
            <input type="submit" value="Rechercher">
            <a href="/admin/manage_moniteurs.php">Reinitialiser</a>
        </div>
    </form>
</section>

<section class="card">
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($moniteurs)): ?>
            <?php foreach ($moniteurs as $moniteur): ?>
            <tr>
                <td><?php echo $moniteur['IdM']; ?></td>
                <td><?php echo htmlspecialchars($moniteur['NomM']); ?></td>
                <td><?php echo htmlspecialchars($moniteur['PrenomM']); ?></td>
                <td>
                    <a href="/admin/actions/edit_moniteur.php?id=<?php echo $moniteur['IdM']; ?>">Modifier</a> |
                    <a href="/admin/actions/delete_moniteur.php?id=<?php echo $moniteur['IdM']; ?>" onclick="return confirm('Etes-vous sur ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Aucun moniteur trouve.</td>
            </tr>
        <?php endif; ?>
    </table>
</section>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>

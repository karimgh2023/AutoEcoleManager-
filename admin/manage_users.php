<?php
require_once __DIR__ . '/../includes/admin_guard.php';

$sql = "SELECT u.*, a.NomA as adherent_nom, a.PrenomA as adherent_prenom FROM utilisateurs u LEFT JOIN Adherent a ON u.adherent_id = a.IdA WHERE 1=1";
$params = [];

if (!empty($_GET['username'])) {
    $sql .= " AND username LIKE ?";
    $params[] = "%" . $_GET['username'] . "%";
}
if (!empty($_GET['role'])) {
    $sql .= " AND role = ?";
    $params[] = $_GET['role'];
}

$stmt = $idcon->prepare($sql);
$stmt->execute($params);
$users = $stmt->fetchAll();

$activePage = 'users';
$pageTitle = 'Gestion des utilisateurs';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<section class="card">
    <div class="section-head">
        <h2>Filtres</h2>
        <a href="/admin/actions/add_user.php">Ajouter un utilisateur</a>
    </div>
    <form method="GET" class="grid grid-3">
        <div>
            <label for="username">Nom d'utilisateur</label>
            <input type="text" id="username" name="username" value="<?php echo isset($_GET['username']) ? $_GET['username'] : ''; ?>">
        </div>
        <div>
            <label for="role">Role</label>
            <select id="role" name="role">
                <option value="">Tous</option>
                <option value="user" <?php if (isset($_GET['role']) && $_GET['role'] === 'user') echo 'selected'; ?>>Utilisateur</option>
                <option value="admin" <?php if (isset($_GET['role']) && $_GET['role'] === 'admin') echo 'selected'; ?>>Administrateur</option>
            </select>
        </div>
        <div class="inline-actions align-end">
            <input type="submit" value="Rechercher">
            <a href="/admin/manage_users.php">Reinitialiser</a>
        </div>
    </form>
</section>

<section class="card">
    <table>
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Role</th>
            <th>ID adherent</th>
            <th>Adherent</th>
            <th>Actions</th>
        </tr>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td><?php echo $user['adherent_id'] ? $user['adherent_id'] : '-'; ?></td>
                <td><?php echo $user['adherent_nom'] ? htmlspecialchars($user['adherent_nom'] . ' ' . $user['adherent_prenom']) : '-'; ?></td>
                <td>
                    <a href="/admin/actions/edit_user.php?id=<?php echo $user['id']; ?>">Modifier</a> |
                    <a href="/admin/actions/delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Etes-vous sur ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Aucun utilisateur trouve.</td>
            </tr>
        <?php endif; ?>
    </table>
</section>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>

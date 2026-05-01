<?php
require_once __DIR__ . '/../includes/admin_guard.php';

$activePage = 'dashboard';
$pageTitle = 'Tableau de bord';

$stats = [
    'users' => (int) $idcon->query("SELECT COUNT(*) FROM utilisateurs")->fetchColumn(),
    'adherents' => (int) $idcon->query("SELECT COUNT(*) FROM Adherent")->fetchColumn(),
    'moniteurs' => (int) $idcon->query("SELECT COUNT(*) FROM Moniteur")->fetchColumn(),
    'seances' => (int) $idcon->query("SELECT COUNT(*) FROM Seance")->fetchColumn(),
];

require_once __DIR__ . '/../includes/admin_header.php';
?>
<section class="grid grid-4">
    <article class="stat-card">
        <p>Utilisateurs</p>
        <strong><?php echo $stats['users']; ?></strong>
    </article>
    <article class="stat-card">
        <p>Adherents</p>
        <strong><?php echo $stats['adherents']; ?></strong>
    </article>
    <article class="stat-card">
        <p>Moniteurs</p>
        <strong><?php echo $stats['moniteurs']; ?></strong>
    </article>
    <article class="stat-card">
        <p>Seances</p>
        <strong><?php echo $stats['seances']; ?></strong>
    </article>
</section>

<section class="card dashboard-actions">
    <h2>Actions rapides</h2>
    <div class="inline-actions">
        <a class="button" href="/admin/actions/add_user.php">Ajouter un utilisateur</a>
        <a class="button" href="/admin/actions/add_adherent.php">Ajouter un adherent</a>
        <a class="button" href="/admin/actions/add_moniteur.php">Ajouter un moniteur</a>
        <a class="button" href="/admin/actions/add_seance.php">Ajouter une seance</a>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>

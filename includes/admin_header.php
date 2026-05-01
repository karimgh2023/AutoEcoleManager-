<?php
$pageTitle = $pageTitle ?? "Administration";
$activePage = $activePage ?? "";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <h2 class="brand-title">AutoEcoleManager</h2>
            <p class="brand-subtitle">Espace administrateur</p>
            <nav class="side-nav">
                <a class="<?php echo $activePage === 'dashboard' ? 'active' : ''; ?>" href="/admin/dashboard.php">Dashboard</a>
                <a class="<?php echo $activePage === 'users' ? 'active' : ''; ?>" href="/admin/manage_users.php">Utilisateurs</a>
                <a class="<?php echo $activePage === 'adherents' ? 'active' : ''; ?>" href="/admin/manage_adherents.php">Adherents</a>
                <a class="<?php echo $activePage === 'moniteurs' ? 'active' : ''; ?>" href="/admin/manage_moniteurs.php">Moniteurs</a>
                <a class="<?php echo $activePage === 'seances' ? 'active' : ''; ?>" href="/admin/manage_seances.php">Seances</a>
                <a href="/logout.php">Se deconnecter</a>
            </nav>
        </aside>
        <main class="admin-main">
            <header class="topbar card">
                <div>
                    <h1 class="page-title"><?php echo htmlspecialchars($pageTitle); ?></h1>
                    <p class="subtitle">Bonjour, <?php echo htmlspecialchars($_SESSION['username']); ?>.</p>
                </div>
            </header>

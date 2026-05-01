<?php
require_once __DIR__ . '/../includes/user_guard.php';
$pageTitle = "Espace utilisateur";
require_once __DIR__ . '/../includes/user_header.php';
?>
<div class="welcome card">
    <h1>Bienvenue dans l'espace utilisateur</h1>
    <p>Bonjour, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> !</p>
    <?php if (!empty($_SESSION['adherent_id'])): ?>
        <p>Adherent ID: <strong><?php echo (int) $_SESSION['adherent_id']; ?></strong> | Nom: <strong><?php echo htmlspecialchars($_SESSION['adherent_prenom'] . ' ' . $_SESSION['adherent_nom']); ?></strong> | Ville: <strong><?php echo htmlspecialchars($_SESSION['adherent_ville']); ?></strong></p>
    <?php else: ?>
        <p><em>Aucun abonnement adherent associe pour ce compte.</em></p>
    <?php endif; ?>
    <p>Decouvrez votre progression et gerez vos sessions de formation.</p>
</div>

<div class="dashboard grid grid-3">
    <div class="card">
        <h3>Prochaines seances</h3>
        <p>Consultez vos prochaines sessions de formation programmees.</p>
        <a href="/user/next_seances.php">Voir mes seances</a>
    </div>

    <div class="card">
        <h3>Mes statistiques</h3>
        <p>Suivez votre progression : heures de formation, nombre de seances, etc.</p>
        <a href="/user/stats.php">Voir mes statistiques</a>
    </div>

    <div class="card">
        <h3>Nos moniteurs</h3>
        <p>Decouvrez nos instructeurs et leurs specialites.</p>
        <a href="/user/moniteurs_info.php">Voir les moniteurs</a>
    </div>

    <div class="card">
        <h3>Historique</h3>
        <p>Consultez l'historique de toutes vos seances passees.</p>
        <a href="/user/seances_history.php">Voir l'historique</a>
    </div>

    <div class="card">
        <h3>Mon profil</h3>
        <p>Mettez a jour vos informations personnelles et votre mot de passe.</p>
        <a href="/user/profile.php">Modifier mon profil</a>
    </div>

    <div class="card">
        <h3>Besoin d'aide ?</h3>
        <p>Consultez nos coordonnees et horaires d'ouverture.</p>
        <a href="/user/contact_info.php">Nous contacter</a>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/user_footer.php'; ?>

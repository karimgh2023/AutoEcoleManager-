<?php
require_once __DIR__ . '/../includes/user_guard.php';
$pageTitle = "Nous contacter";
require_once __DIR__ . '/../includes/user_header.php';
?>
<h1>Nous contacter</h1>
<p>Pour toute question ou reservation, n'hesitez pas a nous contacter.</p>

<div class="grid grid-3">
    <article class="card">
        <h3>Adresse</h3>
        <p><strong>Club de Planche a Voile</strong></p>
        <p>123 Boulevard de la Cote<br>64200 Biarritz<br>France</p>
    </article>

    <article class="card">
        <h3>Telephone</h3>
        <p><strong>Reception</strong><br>+33 5 59 XX XX XX</p>
        <p><strong>Responsable</strong><br>+33 5 59 XX XX XX</p>
    </article>

    <article class="card">
        <h3>Email</h3>
        <p><strong>Support</strong><br><a href="mailto:contact@clubvoile.fr">contact@clubvoile.fr</a></p>
        <p><strong>Reservations</strong><br><a href="mailto:reservations@clubvoile.fr">reservations@clubvoile.fr</a></p>
    </article>
</div>
<?php require_once __DIR__ . '/../includes/user_footer.php'; ?>

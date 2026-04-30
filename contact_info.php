<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nous Contacter</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav { background-color: #f0f0f0; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #0066cc; }
        nav a:hover { text-decoration: underline; }
        .contact-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 20px; }
        .contact-card { 
            border: 1px solid #ddd; 
            padding: 20px; 
            border-radius: 8px; 
            background-color: #f9f9f9;
        }
        .contact-card h3 { margin-top: 0; color: #333; }
        .contact-card p { margin: 10px 0; }
        .icon { font-size: 24px; margin-right: 10px; }
    </style>
</head>
<body>
    <div class="container">
    <nav>
        <a href="main_page.php">← Retour à l'accueil</a>
    </nav>
    
    <h1>Nous Contacter</h1>
    <p>Pour toute question ou réservation, n'hésitez pas à nous contacter.</p>
    
    <div class="contact-grid">
        <div class="contact-card">
            <h3><span class="icon">📍</span>Adresse</h3>
            <p><strong>Club de Planche à Voile</strong></p>
            <p>123 Boulevard de la Côte<br>
            64200 Biarritz<br>
            France</p>
        </div>
        
        <div class="contact-card">
            <h3><span class="icon">📞</span>Téléphone</h3>
            <p><strong>Réception</strong><br>
            +33 5 59 XX XX XX</p>
            <p><strong>Responsable</strong><br>
            +33 5 59 XX XX XX</p>
        </div>
        
        <div class="contact-card">
            <h3><span class="icon">✉️</span>Email</h3>
            <p><strong>Support</strong><br>
            <a href="mailto:contact@clubvoile.fr">contact@clubvoile.fr</a></p>
            <p><strong>Réservations</strong><br>
            <a href="mailto:reservations@clubvoile.fr">reservations@clubvoile.fr</a></p>
        </div>
        
        <div class="contact-card">
            <h3><span class="icon">🕐</span>Horaires</h3>
            <p><strong>Lundi - Vendredi</strong><br>
            09:00 - 19:00</p>
            <p><strong>Samedi - Dimanche</strong><br>
            10:00 - 18:00</p>
        </div>
        
        <div class="contact-card">
            <h3><span class="icon">🌐</span>Réseaux Sociaux</h3>
            <p>
            <a href="#" style="margin-right: 10px;">Facebook</a><br>
            <a href="#" style="margin-right: 10px;">Instagram</a><br>
            <a href="#">Twitter</a>
            </p>
        </div>
        
        <div class="contact-card">
            <h3><span class="icon">❓</span>FAQ</h3>
            <p>
            <a href="#">Conditions générales</a><br>
            <a href="#">Politique de confidentialité</a><br>
            <a href="#">Tarifs et forfaits</a>
            </p>
        </div>
    </div>
    
    <div style="margin-top: 30px; padding: 20px; background-color: #e3f2fd; border-radius: 8px;">
        <h3>Message rapide</h3>
        <form>
            <label for="sujet">Sujet:</label>
            <input type="text" id="sujet" name="sujet" required style="width: 100%; padding: 8px; margin: 10px 0;"><br>
            
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required style="width: 100%; padding: 8px; margin: 10px 0;"></textarea><br>
            
            <input type="submit" value="Envoyer" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
        </form>
    </div>
    </div>
</body>
</html>
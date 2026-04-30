<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $ville = $_POST['ville'];

    $stmt = $idcon->prepare("INSERT INTO Adherent (NomA, PrenomA, Ville) VALUES (?, ?, ?)");
    $stmt->execute([$nom, $prenom, $ville]);

    header("Location: manage_adherents.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Adhérent</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Ajouter un Adhérent</h1>
    <form method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br><br>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required><br><br>
        <label for="ville">Ville:</label>
        <input type="text" id="ville" name="ville" required><br><br>
        <input type="submit" value="Ajouter">
    </form>
    <a href="manage_adherents.php">Retour</a>
    </div>
</body>
</html>
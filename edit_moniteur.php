<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $idcon->prepare("SELECT * FROM Moniteur WHERE IdM = ?");
$stmt->execute([$id]);
$moniteur = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    $stmt = $idcon->prepare("UPDATE Moniteur SET NomM = ?, PrenomM = ? WHERE IdM = ?");
    $stmt->execute([$nom, $prenom, $id]);

    header("Location: manage_moniteurs.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Moniteur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Modifier le Moniteur</h1>
    <form method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo $moniteur['NomM']; ?>" required><br><br>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $moniteur['PrenomM']; ?>" required><br><br>
        <input type="submit" value="Mettre à jour">
    </form>
    <a href="manage_moniteurs.php">Retour</a>
    </div>
</body>
</html>
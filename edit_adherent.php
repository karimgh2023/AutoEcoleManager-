<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $idcon->prepare("SELECT * FROM Adherent WHERE IdA = ?");
$stmt->execute([$id]);
$adherent = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $ville = $_POST['ville'];

    $stmt = $idcon->prepare("UPDATE Adherent SET NomA = ?, PrenomA = ?, Ville = ? WHERE IdA = ?");
    $stmt->execute([$nom, $prenom, $ville, $id]);

    header("Location: manage_adherents.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Adhérent</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Modifier l'Adhérent</h1>
    <form method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?php echo $adherent['NomA']; ?>" required><br><br>
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $adherent['PrenomA']; ?>" required><br><br>
        <label for="ville">Ville:</label>
        <input type="text" id="ville" name="ville" value="<?php echo $adherent['Ville']; ?>" required><br><br>
        <input type="submit" value="Mettre à jour">
    </form>
    <a href="manage_adherents.php">Retour</a>
    </div>
</body>
</html>
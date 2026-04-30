<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $idcon->prepare("SELECT * FROM utilisateurs WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

// Load adherents for association
$adhStmt = $idcon->prepare("SELECT * FROM Adherent ORDER BY NomA, PrenomA");
$adhStmt->execute();
$adherents = $adhStmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $adherent_id = !empty($_POST['adherent_id']) ? $_POST['adherent_id'] : null;

    $stmt = $idcon->prepare("UPDATE utilisateurs SET username = ?, password = ?, role = ?, adherent_id = ? WHERE id = ?");
    $stmt->execute([$username, $password, $role, $adherent_id, $id]);

    header("Location: manage_users.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <h1>Modifier l'Utilisateur</h1>
    <form method="post">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br><br>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="adherent_id">ID Adhérent (pour utilisateur):</label>
        <select id="adherent_id" name="adherent_id">
            <option value="">Aucun</option>
            <?php foreach ($adherents as $a): ?>
                <option value="<?php echo $a['IdA']; ?>" <?php if ($user['adherent_id'] == $a['IdA']) echo 'selected'; ?>><?php echo $a['IdA'] . ' - ' . $a['NomA'] . ' ' . $a['PrenomA']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        <label for="role">Rôle:</label>
        <select id="role" name="role">
            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>Utilisateur</option>
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Administrateur</option>
        </select><br><br>
        <input type="submit" value="Mettre à jour">
    </form>
    <a href="manage_users.php">Retour</a>
    </div>
</body>
</html>
<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_password = $_POST['password'];

    // Update user
    $stmt = $idcon->prepare("UPDATE utilisateurs SET username = ?, password = ? WHERE username = ?");
    $stmt->execute([$new_username, $new_password, $_SESSION['username']]);

    $_SESSION['username'] = $new_username;
    $success = "Profil mis à jour avec succès.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        nav { background-color: #f0f0f0; padding: 10px; border-radius: 5px; margin-bottom: 20px; }
        nav a { margin-right: 15px; text-decoration: none; color: #0066cc; }
        nav a:hover { text-decoration: underline; }
        .profile-container { max-width: 600px; background-color: #f9f9f9; padding: 20px; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input[type="text"], input[type="password"], input[type="email"] { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] { 
            background-color: #4CAF50; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer;
        }
        input[type="submit"]:hover { background-color: #45a049; }
        .success { color: green; background-color: #d4edda; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .info-box { background-color: #e3f2fd; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
    <nav>
        <a href="main_page.php">← Retour à l'accueil</a>
    </nav>
    
    <div class="profile-container">
        <h1>Mon Profil</h1>
        
        <?php if (isset($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <div class="info-box">
            <p><strong>Utilisateur actuel:</strong> <?php echo $_SESSION['username']; ?></p>
            <p><strong>Rôle:</strong> <?php echo $_SESSION['role'] == 'admin' ? 'Administrateur' : 'Utilisateur'; ?></p>
        </div>
        
        <h2>Modifier mes Informations</h2>
        <form method="post">
            <div class="form-group">
                <label for="username">Nouveau nom d'utilisateur:</label>
                <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Nouveau mot de passe:</label>
                <input type="password" id="password" name="password" placeholder="Entrez votre nouveau mot de passe" required>
            </div>
            
            <input type="submit" value="Mettre à jour mon profil">
        </form>
        
        <hr style="margin: 30px 0;">
        
        <h3>Sécurité</h3>
        <p>Votre mot de passe doit contenir au moins 8 caractères et mélanger majuscules, minuscules et chiffres.</p>
        <p>Pour une sécurité maximale, utilisez un mot de passe unique que vous n'utilisez nulle part ailleurs.</p>
    </div>
</body>
</html>
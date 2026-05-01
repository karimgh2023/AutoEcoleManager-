<?php
declare(strict_types=1);

$host = "localhost";
$user = "root";
$password = "";
$dbName = "gestion_cours";

try {
    $pdo = new PDO("mysql:host=$host", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbName`");

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS Adherent (
            IdA INT AUTO_INCREMENT PRIMARY KEY,
            NomA VARCHAR(100) NOT NULL,
            PrenomA VARCHAR(100) NOT NULL,
            Ville VARCHAR(100) NOT NULL
        ) ENGINE=InnoDB"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS Moniteur (
            IdM INT AUTO_INCREMENT PRIMARY KEY,
            NomM VARCHAR(100) NOT NULL,
            PrenomM VARCHAR(100) NOT NULL
        ) ENGINE=InnoDB"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS utilisateurs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
            adherent_id INT NULL,
            CONSTRAINT fk_utilisateur_adherent
                FOREIGN KEY (adherent_id) REFERENCES Adherent(IdA)
                ON DELETE SET NULL
                ON UPDATE CASCADE
        ) ENGINE=InnoDB"
    );

    $pdo->exec(
        "CREATE TABLE IF NOT EXISTS Seance (
            IdM INT NOT NULL,
            IdA INT NOT NULL,
            DateS DATE NOT NULL,
            HeureS TIME NOT NULL,
            NbHeures INT NOT NULL,
            PRIMARY KEY (IdM, IdA, DateS),
            CONSTRAINT fk_seance_moniteur
                FOREIGN KEY (IdM) REFERENCES Moniteur(IdM)
                ON DELETE CASCADE
                ON UPDATE CASCADE,
            CONSTRAINT fk_seance_adherent
                FOREIGN KEY (IdA) REFERENCES Adherent(IdA)
                ON DELETE CASCADE
                ON UPDATE CASCADE
        ) ENGINE=InnoDB"
    );

    $adminCheck = $pdo->prepare("SELECT id FROM utilisateurs WHERE username = ?");
    $adminCheck->execute(["admin"]);
    $adminExists = $adminCheck->fetchColumn();

    if (!$adminExists) {
        $insertAdmin = $pdo->prepare(
            "INSERT INTO utilisateurs (username, password, role, adherent_id) VALUES (?, ?, 'admin', NULL)"
        );
        $insertAdmin->execute(["admin", "admin123"]);
        echo "Base de donnees creee. Compte admin ajoute: admin / admin123" . PHP_EOL;
    } else {
        echo "Base de donnees verifiee. Le compte admin existe deja." . PHP_EOL;
    }
} catch (PDOException $e) {
    echo "Erreur setup: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

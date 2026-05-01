<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    set_flash('error', "Identifiant utilisateur invalide.");
    header("Location: /admin/manage_users.php");
    exit();
}

try {
    $stmt = $idcon->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$id]);
    if ($stmt->rowCount() > 0) {
        set_flash('success', "Utilisateur supprime avec succes.");
    } else {
        set_flash('error', "Utilisateur introuvable.");
    }
} catch (PDOException $e) {
    set_flash('error', "Impossible de supprimer l'utilisateur.");
}

header("Location: /admin/manage_users.php");
exit();

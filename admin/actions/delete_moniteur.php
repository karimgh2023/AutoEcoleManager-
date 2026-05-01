<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    set_flash('error', "Identifiant moniteur invalide.");
    header("Location: /admin/manage_moniteurs.php");
    exit();
}

try {
    $stmt = $idcon->prepare("DELETE FROM Moniteur WHERE IdM = ?");
    $stmt->execute([$id]);
    if ($stmt->rowCount() > 0) {
        set_flash('success', "Moniteur supprime avec succes.");
    } else {
        set_flash('error', "Moniteur introuvable.");
    }
} catch (PDOException $e) {
    set_flash('error', "Impossible de supprimer le moniteur.");
}

header("Location: /admin/manage_moniteurs.php");
exit();

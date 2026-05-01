<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    set_flash('error', "Identifiant adherent invalide.");
    header("Location: /admin/manage_adherents.php");
    exit();
}

try {
    $stmt = $idcon->prepare("DELETE FROM Adherent WHERE IdA = ?");
    $stmt->execute([$id]);
    if ($stmt->rowCount() > 0) {
        set_flash('success', "Adherent supprime avec succes.");
    } else {
        set_flash('error', "Adherent introuvable.");
    }
} catch (PDOException $e) {
    set_flash('error', "Impossible de supprimer l'adherent.");
}

header("Location: /admin/manage_adherents.php");
exit();

<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$idm = isset($_GET['idm']) ? (int) $_GET['idm'] : 0;
$ida = isset($_GET['ida']) ? (int) $_GET['ida'] : 0;
$date = (string) ($_GET['date'] ?? '');

if ($idm <= 0 || $ida <= 0 || $date === '') {
    set_flash('error', "Parametres de seance invalides.");
    header("Location: /admin/manage_seances.php");
    exit();
}

try {
    $stmt = $idcon->prepare("DELETE FROM Seance WHERE IdM = ? AND IdA = ? AND DateS = ?");
    $stmt->execute([$idm, $ida, $date]);
    if ($stmt->rowCount() > 0) {
        set_flash('success', "Seance supprimee avec succes.");
    } else {
        set_flash('error', "Seance introuvable.");
    }
} catch (PDOException $e) {
    set_flash('error', "Impossible de supprimer la seance.");
}

header("Location: /admin/manage_seances.php");
exit();

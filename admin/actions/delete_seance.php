<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$idm = isset($_GET['idm']) ? (int) $_GET['idm'] : 0;
$ida = isset($_GET['ida']) ? (int) $_GET['ida'] : 0;
$date = (string) ($_GET['date'] ?? '');

if ($idm > 0 && $ida > 0 && $date !== '') {
    $stmt = $idcon->prepare("DELETE FROM Seance WHERE IdM = ? AND IdA = ? AND DateS = ?");
    $stmt->execute([$idm, $ida, $date]);
}

header("Location: /admin/manage_seances.php");
exit();

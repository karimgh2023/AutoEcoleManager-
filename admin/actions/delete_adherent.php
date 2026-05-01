<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id > 0) {
    $stmt = $idcon->prepare("DELETE FROM Adherent WHERE IdA = ?");
    $stmt->execute([$id]);
}

header("Location: /admin/manage_adherents.php");
exit();

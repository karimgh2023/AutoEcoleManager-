<?php
require_once __DIR__ . '/../../includes/admin_guard.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id > 0) {
    $stmt = $idcon->prepare("DELETE FROM Moniteur WHERE IdM = ?");
    $stmt->execute([$id]);
}

header("Location: /admin/manage_moniteurs.php");
exit();

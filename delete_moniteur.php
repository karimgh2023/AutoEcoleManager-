<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $idcon->prepare("DELETE FROM Moniteur WHERE IdM = ?");
$stmt->execute([$id]);

header("Location: manage_moniteurs.php");
exit();
?>
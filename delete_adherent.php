<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $idcon->prepare("DELETE FROM Adherent WHERE IdA = ?");
$stmt->execute([$id]);

header("Location: manage_adherents.php");
exit();
?>
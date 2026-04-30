<?php
include 'connector.php';
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$idm = $_GET['idm'];
$ida = $_GET['ida'];
$date = $_GET['date'];
$stmt = $idcon->prepare("DELETE FROM Seance WHERE IdM = ? AND IdA = ? AND DateS = ?");
$stmt->execute([$idm, $ida, $date]);

header("Location: manage_seances.php");
exit();
?>
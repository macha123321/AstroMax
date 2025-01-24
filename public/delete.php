<?php
include '../config/db.php';

$attractionID = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM attractions WHERE attractionID = :attractionID");
$stmt->execute(['attractionID' => $attractionID]);

header('Location: employee.php');
exit();
?>
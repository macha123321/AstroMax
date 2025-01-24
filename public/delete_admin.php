<?php
include '../config/db.php';

$bookingID = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM bookings WHERE bookingID = :bookingID");
$stmt->execute(['bookingID' => $bookingID]);

header('Location: employee.php');
exit();
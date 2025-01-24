<?php
include '../config/db.php';

$bookingID = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM bookings WHERE bookingID = :bookingID");
$stmt->execute(['bookingID' => $bookingID]);
$booking = $stmt->fetch();
$date = new DateTime();
$date->modify('+2 days');
$two_days_later = $date->format('Y-m-d');

if ($booking['day'] > $two_days_later) {

    $deleteStmt = $pdo->prepare("DELETE FROM bookings WHERE bookingID = :bookingID");
    $deleteStmt->execute(['bookingID' => $bookingID]);

    header('Location: customer.php');
    exit();
} else {
    echo "<script>         
    alert('You cannot refund the booking as it is within 2 days.');         
    window.location.href = 'customer.php';     
    </script>";     
    exit();
}
?>

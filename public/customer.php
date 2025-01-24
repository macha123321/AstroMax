<?php include '../config/db.php'; ?> 

<?php include '../templates/header.php'; ?>

<?php include '../templates/nav.php' ?>

<?php $userID = $_SESSION['userID'] ?>

<?php 
$query = $pdo->prepare("SELECT * FROM bookings WHERE userID = :userID");
$query->execute(['userID' => $userID]);
$bookings = $query->fetchAll();
$date = new DateTime();
$day = $date->format('Y-m-d');
?>

<h1>Manage Bookings:</h1>
<?php foreach($bookings as $booking): ?>

    <?php 

    if ($booking['day'] >= $day ) {

    $query = $pdo->prepare("SELECT * FROM attractions WHERE attractionID = :attractionID");
    $query->execute(['attractionID' => $booking["attractionID"]]);
    $activity = $query->fetch();

    ?>

    <strong>Name:</strong> <?php echo htmlspecialchars($activity["attractionName"]); ?> <br>
    <strong>Group Size:</strong> <?php echo htmlspecialchars($booking["groupSize"]); ?> <br>
    <strong>Day:</strong> <?php echo htmlspecialchars($booking["day"]); ?> <br>
    <strong>Time:</strong> <?php echo htmlspecialchars($booking["timeSlot"]); ?> <br>
    <strong>Total Cost:</strong> £<?php echo htmlspecialchars($booking["totalCost"]); ?> <br>
    <a href="delete_booking.php?id=<?php echo $booking['bookingID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
    <br><br>

<?php } else { 

    $deleteStmt = $pdo->prepare("DELETE FROM bookings WHERE bookingID = :bookingID");
    $deleteStmt->execute(['bookingID' => $booking['bookingID']]);

} ?>
<?php endforeach; ?>

<?php include '../templates/footer.php'; ?>

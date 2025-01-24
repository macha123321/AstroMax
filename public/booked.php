<?php
$attractionID = $_GET['id'] ?? null;
$selectedDay = $_GET['day'] ?? null;
$selectedTime = $_GET['time'] ?? null;
$groupSize = $_GET['size'] ?? null;

if (!$attractionID || !$selectedDay || !$selectedTime || !$groupSize) {
    die("Missing required information.");
}


include '../config/db.php';
$query = $pdo->prepare("SELECT * FROM attractions WHERE attractionID = :attractionID");
$query->execute(['attractionID' => $attractionID]);
$activity = $query->fetch();


?>

<?php include '../templates/header.php'; ?>
<?php include '../templates/nav.php'; ?>

<?php
$cost = $groupSize * $activity['price'];

$query = $pdo->prepare("INSERT INTO bookings (userID, attractionID, day, timeSlot, groupSize,totalCost) 
                        VALUES (:userID, :attractionID, :day, :timeSlot, :groupSize, :totalCost)");
$query->execute([
    'userID' => $_SESSION['userID'],
    'attractionID' => $attractionID,
    'day' => $selectedDay,
    'timeSlot' => $selectedTime,
    'groupSize' => $groupSize,
    'totalCost' => $cost
]);
?>

<h1>Booking Confirmation</h1>

<p>You have successfully booked a slot for the attraction:</p>
<p><strong>Attraction:</strong> <?php echo htmlspecialchars($activity['attractionName']); ?></p>
<p><strong>Group Size:</strong> <?php echo htmlspecialchars($groupSize); ?></p>
<p><strong>Date:</strong> <?php echo htmlspecialchars($selectedDay); ?></p>
<p><strong>Time:</strong> <?php echo htmlspecialchars($selectedTime); ?></p>
<p><strong>Total Cost:</strong> £<?php echo htmlspecialchars($cost); ?></p>


<?php include '../templates/footer.php'; ?>
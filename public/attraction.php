<?php

include '../config/db.php';

$attractionID = $_GET['id'] ?? null;

if (!$attractionID) {
    die("Attraction ID not provided.");
};
$query = $pdo->prepare("SELECT * FROM attractions WHERE attractionID = :attractionID");
$query->execute(['attractionID' => $attractionID]);
$activity = $query->fetch();

include '../templates/header.php';

include '../templates/nav.php';

?>

<div class="general-bg" style="background-image: url('img/<?php echo htmlspecialchars($activity["img"]); ?>');">
<h1 class = "caption"><?php echo htmlspecialchars($activity["attractionName"]); ?></h1>
</div>
<h1 class="title">Information</h1>

<h2 class = "header">Description:</h2>
<h3 class="text"><?php echo htmlspecialchars($activity["description"]); ?></h3>

<h2 class = "header">Group Size:</h2>
<h3 class="text">1-<?php echo htmlspecialchars($activity["maxCapacity"]); ?></h3>

<h2 class = "header">Price:</h2>
<h3 class="text">£<?php echo htmlspecialchars($activity["price"]); ?> per person</h3>

<button onclick="LoggedIn()" class="book">Book Now!</button>

<script>
function LoggedIn() {
    <?php if ($isLoggedIn): ?>
        window.location.href = 'booking.php?id=<?php echo $activity['attractionID']; ?>';
    <?php else: ?>
        alert('You need to be logged in to book!');
        window.location.href = 'Login.php';
    <?php endif; ?>
}
</script>

<?php include '../templates/footer.php'; ?>
<?php

include '../config/db.php';

$query = $pdo->query("SELECT * FROM attractions WHERE availablity = 1");
$activities = $query->fetchAll(PDO::FETCH_ASSOC);

include '../templates/header.php';

include '../templates/nav.php';

?>
<div class = "general-bg"></div>


<h1 class = "title" id="activities">
    Activities
</h1>

<?php foreach ($activities as $activity):   ?>
    <div class="attraction" style="background-image: url('img/<?php echo htmlspecialchars($activity["img"]); ?>');">
            <h2><?php echo htmlspecialchars($activity["attractionName"]); ?></h2>
            <h3><?php echo htmlspecialchars($activity["overview"]); ?></h3>
            <button onclick="window.location.href='attraction.php?id=<?php echo $activity['attractionID']; ?>'">BOOK NOW!</button>
        </div>
<?php endforeach; ?>


<?php include '../templates/footer.php'; ?>


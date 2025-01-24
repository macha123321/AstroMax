<?php
$pdo = new PDO('mysql:host=localhost;dbname=activity_booking', 'root', '');

$query = "SELECT DISTINCT day FROM slots WHERE day >= CURDATE() ORDER BY day ASC";
$stmt = $pdo->query($query);
$days = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode($days);
?>

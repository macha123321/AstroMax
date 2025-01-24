<?php
$pdo = new PDO('mysql:host=localhost;dbname=activity_booking', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$data = json_decode(file_get_contents('php://input'), true);
$day = $data['day'];
$time = $data['time'];

try {

    $checkQuery = "SELECT is_booked FROM slots WHERE day = :day AND time = :time";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute(['day' => $day, 'time' => $time]);
    $slot = $checkStmt->fetch(PDO::FETCH_ASSOC);

    $updateQuery = "UPDATE slots SET is_booked = 1 WHERE day = :day AND time = :time";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute(['day' => $day, 'time' => $time]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    echo json_encode(['error' => 'Database error occurred.']);
}
?>

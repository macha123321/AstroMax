<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=activity_booking', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $day = $_GET['day'];
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');

    if ($day == $current_date) {
        $query = "SELECT time, is_booked FROM slots WHERE day = :day AND time >= :current_time ORDER BY time ASC";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['day' => $day, 'current_time' => $current_time]);
    } else {
        $query = "SELECT time, is_booked FROM slots WHERE day = :day ORDER BY time ASC";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['day' => $day]);
    }

    $slots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    error_log("Fetched Slots: " . json_encode($slots));
    echo json_encode($slots);

} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "Database error occurred."]);
}
?>

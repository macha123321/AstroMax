<?php
include '../config/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$attractionID = $data['attractionID'] ?? null;
$selectedDay = $data['day'] ?? null;

if (!$attractionID || !$selectedDay) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

$times = [
    "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", 
    "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00", "00:00"
];

$availableSlots = [];

foreach ($times as $time) {
    $query = $pdo->prepare("SELECT * FROM bookings WHERE attractionID = :attractionID AND day = :day AND timeSlot = :timeSlot");
    $query->execute([
        'attractionID' => $attractionID, 
        'day' => $selectedDay, 
        'timeSlot' => $time
    ]);
    $slot = $query->fetch();

    $availableSlots[] = [
        'time' => $time,
        'isBooked' => (bool)$slot
    ];
}

echo json_encode(['slots' => $availableSlots]);
?>

<?php
include '../config/db.php';

$attractionID = $_GET['id'] ?? null;
if (!$attractionID) {
    die("Attraction ID not provided.");
}

$selectedDay = $_GET['day'] ?? (new DateTime('tomorrow'))->format('Y-m-d');

$query = $pdo->prepare("SELECT * FROM attractions WHERE attractionID = :attractionID");
$query->execute(['attractionID' => $attractionID]);
$activity = $query->fetch();

$times = [
    "09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", 
    "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00", "00:00"
];

$startDate = new DateTime();
$endDate = clone $startDate;
$endDate->add(new DateInterval('P13W'));
$tomorrow = new DateTime('tomorrow');
$interval = new DateInterval('P1D');
$period = new DatePeriod($startDate, $interval, $endDate);

include '../templates/header.php';
include '../templates/nav.php';
?>

<h1>Book A Time Slot!</h1>

<label for="size">Group Size:</label>
<input type="number" name="size" id="size" value="1" max="<?php echo $activity['maxCapacity']; ?>" min="1">

<?php
$groupSize = $_GET['size'] ?? 1;
$cost = $groupSize * $activity['price'];
?>
<p>Total Cost: <span id="totalCost"><?php echo htmlspecialchars(number_format($cost, 2)); ?></span></p>

<form id="bookingForm" method="get">
    <label for="day">Select a Day:</label>
    <select name="day" id="day">
        <?php foreach ($period as $date): ?>
            <?php 
                if ($date->format('Y-m-d') == $startDate->format('Y-m-d')) {
                    continue;
                }
            ?>
            <option value="<?php echo $date->format('Y-m-d'); ?>" 
                    <?php if ($date->format('Y-m-d') == $selectedDay) echo 'selected'; ?>>
                <?php echo $date->format('l, F j, Y'); ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <input type="hidden" name="id" value="<?php echo $attractionID; ?>">
</form>

<br>

<div id="availableSlots"></div>

<?php 
include '../templates/footer.php';
?>

<script>

document.addEventListener("DOMContentLoaded", function() {
    const sizeInput = document.getElementById("size");
    const costDisplay = document.getElementById("totalCost");
    const price = <?php echo $activity['price']; ?>;

    function updateTotalCost() {
        const size = sizeInput.value;
        const totalCost = size * price;
        costDisplay.textContent = `£${totalCost.toFixed(2)}`;
    }

    sizeInput.addEventListener('input', updateTotalCost);

    updateTotalCost();
});

document.addEventListener("DOMContentLoaded", function() {
    const daySelect = document.getElementById("day");
    const sizeInput = document.getElementById("size");

    function loadAvailableSlots() {
        const selectedDay = daySelect.value;
        const attractionID = "<?php echo $attractionID; ?>";

        fetch('load_slots.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                attractionID: attractionID,
                day: selectedDay
            })
        })
        .then(response => response.json())
        .then(data => {
            const slotsContainer = document.getElementById('availableSlots');
            slotsContainer.innerHTML = '';

            data.slots.forEach(slot => {
                const button = document.createElement('button');
                button.textContent = slot.time;
                button.disabled = slot.isBooked;
                
                button.addEventListener('click', function() {
                    const size = sizeInput.value;
                    window.location.href = `booked.php?id=${attractionID}&day=${selectedDay}&time=${slot.time}&size=${size}`;
                });

                slotsContainer.appendChild(button);
            });
        })
        .catch(error => console.error('Error loading available slots:', error));
    }

    daySelect.addEventListener('change', loadAvailableSlots);
    loadAvailableSlots();
});
</script>

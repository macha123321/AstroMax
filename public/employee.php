<?php
session_start();
include '../config/db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $userID = intval($_POST['userID']);
    $newRole = $_POST['role'];


    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE userID = ?");
    $stmt->execute([$newRole, $userID]);


    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

$query = $pdo->query("SELECT * FROM users");
$users = $query->fetchAll(PDO::FETCH_ASSOC);
$query = $pdo->query("SELECT * FROM attractions");
$attractions = $query->fetchAll(PDO::FETCH_ASSOC);
$query = $pdo->query("SELECT * FROM bookings");
$bookings = $query->fetchAll(PDO::FETCH_ASSOC);
$role = $_SESSION['role'];
$id = $_SESSION['userID'];
if ($role == 'Customer') {
    die("You are not an authorised user.");
}
?>

<?php include '../templates/header.php'; ?>

<?php if ($role == 'Admin') { ?>
    <header>
        <h1>Administrator Dashboard</h1>
    </header>
<?php } else { ?>
    <header>
        <h1>Staff Dashboard</h1>
    </header>
<?php } ?>

<?php if ($role == 'Admin') { ?>
<h2>Manage Users</h2>
<div class="users-container">
    <?php foreach ($users as $user): ?>
        <?php if ($id != $user['userID']) { ?>
        <div class="container-user">
            <form method="POST">
                <strong>Name:</strong> <?php echo htmlspecialchars($user["Name"]); ?> <br>
                <strong>Email:</strong> <?php echo htmlspecialchars($user["email"]); ?> <br>
                <strong>Phone Number:</strong> <?php echo htmlspecialchars($user["phonenumber"]); ?> <br>
                <strong>Role:</strong> 
                <select name="role">
                    <option value="Customer" <?php if ($user['role'] === 'Customer') echo 'selected'; ?>>Customer</option>
                    <option value="Staff" <?php if ($user['role'] === 'Staff') echo 'selected'; ?>>Staff</option>
                    <option value="Admin" <?php if ($user['role'] === 'Admin') echo 'selected'; ?>>Admin</option>
                </select>
                <input type="hidden" name="userID" value="<?php echo htmlspecialchars($user['userID']); ?>">
                <button type="submit" name="update_role">Update Role</button>
            </form>
        </div>
        <br><br>
        <?php } ?>
    <?php endforeach; ?>
</div>

<h2>Manage Attractions</h2> 
<div class="attractions-container">
    <?php foreach($attractions as $activity): ?>
        <div class="container-activity">
            <strong>Name:</strong> <?php echo htmlspecialchars($activity["attractionName"]); ?> <br>
            <strong>Description:</strong> <?php echo htmlspecialchars($activity["description"]); ?> <br>
            <strong>Overview:</strong> <?php echo htmlspecialchars($activity["overview"]); ?> <br>
            <strong>Price:</strong> £<?php echo htmlspecialchars($activity["price"]); ?> <br>
            <strong>Image Link:</strong> <?php echo htmlspecialchars($activity["img"]); ?> <br>
            <strong>Max Capacity:</strong> <?php echo htmlspecialchars($activity["maxCapacity"]); ?> <br>
            <strong>Available:</strong> <?php echo $activity["availablity"] ? "Yes" : "No"; ?> <br>
            <a href="edit.php?id=<?php echo $activity['attractionID']; ?>">Edit</a>
            <a href="delete.php?id=<?php echo $activity['attractionID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </div>
        <br><br>
    <?php endforeach; ?>
    <a href="add.php">Add Attraction</a>
</div>
<?php } ?>


<h2>Manage Bookings</h2>

<?php foreach($bookings as $booking): ?>

<?php 

$query = $pdo->prepare("SELECT * FROM users WHERE userID = :userID");
$query->execute(['userID' => $booking["userID"]]);
$user = $query->fetch();

$query = $pdo->prepare("SELECT * FROM attractions WHERE attractionID = :attractionID");
$query->execute(['attractionID' => $booking["attractionID"]]);
$activity = $query->fetch();

?>

<strong>User Name:</strong> <?php echo htmlspecialchars($user["Name"]); ?> <br>
<strong>Attraction Name:</strong> <?php echo htmlspecialchars($activity["attractionName"]); ?> <br>
<strong>Group Size:</strong> <?php echo htmlspecialchars($booking["groupSize"]); ?> <br>
<strong>Day:</strong> <?php echo htmlspecialchars($booking["day"]); ?> <br>
<strong>Time:</strong> <?php echo htmlspecialchars($booking["timeSlot"]); ?> <br>
<strong>Total Cost:</strong> £<?php echo htmlspecialchars($booking["totalCost"]); ?> <br>
<strong>Date Booked:</strong> <?php echo htmlspecialchars($booking["dateBooked"]); ?> <br>
<a href="delete_admin.php?id=<?php echo $booking['bookingID']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
<br><br>

<?php endforeach; ?>


<a href="index.php">General Page</a>
<a href="customer.php">Your Bookings</a>
<button id="logout-btn" class="logout">Logout</button>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('logout-btn').addEventListener('click', function () {
        window.location.href = 'logout.php';
    });
});
</script>
<?php include '../templates/footer.php'; ?>




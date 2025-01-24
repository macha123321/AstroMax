<?php
include '../config/db.php';

$attractionID = $_GET['id'];

$query = $pdo->prepare("SELECT * FROM attractions WHERE attractionID = :attractionID");
$query->execute(['attractionID' => $attractionID]);
$activity = $query->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $attractionName = $_POST['attractionName'];
    $description = $_POST['description'];
    $overview = $_POST['overview'];
    $price = $_POST['price'];
    $img = $_POST['img'];
    $maxCapacity = $_POST['maxCapacity'];
    $available = isset($_POST['available']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE attractions SET attractionName = :attractionName, description = :description, overview = :overview, price = :price, img = :img, maxCapacity = :maxCapacity, availablity = :availablity WHERE attractionID = :attractionID");
    $stmt->execute([
        'attractionName' => $attractionName,
        'description' => $description,
        'overview' => $overview,
        'price' => $price,
        'img' => $img,
        'maxCapacity' => $maxCapacity,
        'availablity' => $available,
        'attractionID' => $attractionID
    ]);

    header('Location: employee.php');
    exit();
}
?>

<?php include '../templates/header.php' ?>

<header>
    <h1>Edit Item</h1>
</header>
<body>
    <div class="container-activity">
        <form method="POST" action="edit.php?id=<?php echo $attractionID; ?>">
            <label for="attractionName">Name:</label>
            <input type="text" name="attractionName" id="attractionName" value="<?php echo htmlspecialchars($activity['attractionName']); ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?php echo htmlspecialchars($activity['description']); ?></textarea>

            <label for="overview">Overview:</label>
            <textarea name="overview" id="overview" required><?php echo htmlspecialchars($activity['overview']); ?></textarea>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($activity['price']); ?>" step="0.01" min="0" required>

            <label for="img">Image Link:</label>
            <input type="text" name="img" id="img" value="<?php echo htmlspecialchars($activity['img']); ?>" required>

            <label for="maxCapacity">Max Capacity:</label>
            <input type="number" name="maxCapacity" id="maxCapacity" value="<?php echo htmlspecialchars($activity['maxCapacity']); ?>" min="0" required>

            <label for="available">Available:</label>
            <input type="checkbox" name="available" id="available" value="1" <?php echo $activity['availablity'] ? 'checked' : ''; ?>> Yes
            <button type="submit">Update Item</button>
        </form>
    </div>
</body>

<?php include '../templates/footer.php' ?>

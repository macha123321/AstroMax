<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $attractionName = $_POST['attractionName'];
    $description = $_POST['description'];
    $overview = $_POST['overview'];
    $price = $_POST['price'];
    $maxCapacity = $_POST['maxCapacity'];
    $availablity = isset($_POST['availablity']) ? 1 : 0;

    $targetDir = "img/";
    $targetFile = $targetDir . basename($_FILES["img"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["img"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File is not an image.');</script>";
        $uploadOk = 0;
    }

    if (file_exists($targetFile)) {
        echo "<script>alert('Sorry, file already exists.');</script>";
        $uploadOk = 0;
    }

    if ($_FILES["img"]["size"] > 5000000) {
        echo "<script>alert('Sorry, your file is too large.');</script>";
        $uploadOk = 0;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG, and GIF files are allowed.');</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $targetFile)) {
            $img = basename($_FILES["img"]["name"]); 
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            $img = '';
        }
    }

    if ($uploadOk == 1 && !empty($img)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO attractions (attractionName, description, overview, price, img, maxCapacity, availablity) 
                                   VALUES (:attractionName, :description, :overview, :price, :img, :maxCapacity, :availablity)");
            $stmt->execute([
                'attractionName' => $attractionName,
                'description' => $description,
                'overview' => $overview,
                'price' => $price,
                'img' => $img,
                'maxCapacity' => $maxCapacity,
                'availablity' => $availablity
            ]);

            echo "<script>
                    alert('Attraction added successfully!');
                    window.location.href = 'employee.php';
                  </script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

<?php include '../templates/header.php' ?>

<header>
    <h1>Add Attraction</h1>
</header>

<body>
    <div class="container">
        <form method="POST" action="add.php" enctype="multipart/form-data">
            <label for="attractionName">Attraction Name:</label>
            <input type="text" name="attractionName" id="attractionName" required placeholder="Enter attraction name">

            <label for="description">Description:</label>
            <textarea name="description" id="description" required placeholder="Enter description"></textarea>

            <label for="overview">Overview:</label>
            <textarea name="overview" id="overview" maxlength="106" required placeholder="Enter overview"></textarea>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" required step="0.01" placeholder="Enter price">

            <label for="img">Image:</label>
            <input type="file" name="img" id="img" required>

            <label for="maxCapacity">Max Capacity:</label>
            <input type="number" name="maxCapacity" id="maxCapacity" required placeholder="Enter Max Capacity">

            <label for="availablity">Available:</label>
            <input type="checkbox" name="availablity" id="availablity" checked>

            <button type="submit">Add Attraction</button>
        </form>
    </div>
    <a href="employee.php">Dashboard</a>
</body>

<?php include '../templates/footer.php' ?>

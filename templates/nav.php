<?php session_start(); 

$isLoggedIn = isset($_SESSION['role']) && isset($_SESSION['Name']) && isset($_SESSION['userID']);
$role = $isLoggedIn ? $_SESSION['role'] : null;

?>

<header class="navbar">
    <div class="logo">
        <a href="index.php">
            <img src="img/logo.png" alt="AstroMax Logo" class="logo">
        </a>
    </div>
    <div class="nav-links">
        <nav>
            <a href="index.php#activities" class="nav-link">Activities</a>
            <a href="" class="nav-link">FAQs</a>
            <a href="" class="nav-link">About Us</a>
            <?php if ($role == 'Customer') { ?>
                <a href="customer.php" class="nav-link">Dashboard</a>
            <?php } else if ($role == 'Admin' || $role == 'Staff') { ?>
                <a href="employee.php" class="nav-link">Dashboard</a>
            <?php } ?>
        </nav>    
    </div>
    <?php if (!$isLoggedIn) { ?>
    <div class="log-container">
        <a href="Login.php" class="log-link">Login | Register</a>
    </div>
    <?php } else { ?>
        <button id="logout-btn" class="logout">Logout</button>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('logout-btn').addEventListener('click', function () {
                window.location.href = 'logout.php';
            });
        });
        </script>
    <?php } ?>
</header>
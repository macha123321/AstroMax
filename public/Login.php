<?php

session_start();

include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo-> prepare('SELECT * FROM users WHERE  email = :email');

    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['userID'] = $user['userID'];
        $_SESSION['Name'] = $user['Name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'Customer') {
            header ('Location: index.php');
            exit();
        } else {
            header('Location: employee.php');
            exit();
        }
    } else {
        $error = 'Invalid username or password';
    }
}
?>


<?php include '../templates/header.php' ?>

<header>
    <h1>Login</h1>
</header>

<form action="Login.php" method="post">
    <br>
    <label>Email:</label><br>
    <input type="email" name="email" id="email" required>
    <br><br>
    <label>Password:</label><br>
    <input type="password" name="password" id="password" required>
    <br><br>
    <button type="submit">Login</button>
</form>

<p><a href="Register.php">Don't have an account?</a> | <a href="index.php">General Page</a></p>

<?php include '../templates/footer.php'?>
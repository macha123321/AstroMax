<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $email = trim($_POST['email']);
    $phone = $_POST['phone'];

    function specialChars($str) {
        return preg_match('/[^a-zA-Z0-9]/', $str);;
    }

    try {
        if (strlen($password) >= 8) {
            if (specialChars($password)) {
                if ($password === $confirm) {
                    
                    $password = password_hash($password, PASSWORD_DEFAULT);

                    $stmt = $pdo->prepare('INSERT INTO users (name, password, email, phonenumber ) VALUES (:Name, :password, :email, :phonenumber )');

                    $stmt->execute(['Name' => $name, 'password' => $password, 'email' => $email, 'phonenumber' => $phone]);

                    echo "<script>         
                        alert('Successfully Registered');         
                        window.location.href = 'Login.php';     
                        </script>";     
                        exit();
                } else {
                    echo "<script>         
                        alert('Password and Confirm Password does not match');         
                        window.location.href = 'Register.php';     
                        </script>";     
                        exit();
                }
            } else {
                echo "<script>         
                        alert('Password should contain atleaset 1 special character');         
                        window.location.href = 'Register.php';     
                        </script>";     
                        exit();
            }
        } else {
            echo "<script>         
                    alert('Password should be atleast 8 characters long');         
                    window.location.href = 'Register.php';     
                    </script>";     
                    exit();
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<script>         
                alert('Email already in use. Please choose another.');         
                window.location.href = 'Register.php';     
                </script>";     
                exit();
        } else {
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    }
}

?>


<?php include '../templates/header.php' ?>

<header>
    <h1>Register</h1>
</header>

<form action="Register.php" method="post">
    <br>
    <label>Name:</label><br>
    <input type="text" name="name" id="name" required>
    <br><br>
    <label>Password:</label><br>
    <input type="password" name="password" id="password" required>
    <br><br>
    <label>Confirm Password:</label><br>
    <input type="password" name="confirm" id="confirm" required>
    <br><br>
    <label>Email:</label><br>
    <input type="email" name="email" id="email" required>
    <br><br>
    <label>Phone Number:</label><br>
    <input type="tel" name="phone" id="phone" required>
    <br><br>
    <button type="submit">Register</button>
</form>

<p><a href="Login.php">Already have an account?</a> | <a href="index.php">General Page</a></p>

<?php include '../templates/footer.php'?>
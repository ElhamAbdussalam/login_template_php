<?php

include "database/database.php";

// Sign IN
session_start();
$login_message = "";

if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
    exit;
}

if (isset($_POST['signIn'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hash_password = hash('sha256', $password);

    $sql = "SELECT * FROM users WHERE username = '$username' AND password='$hash_password'";

    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION["username"] = $data["username"];
        $_SESSION["role"] = $data["role"];
        $_SESSION["is_login"] = true;

        if ($data['role'] == 'admin') {
            header('Location: admin.php');
        } else if ($data['role'] == 'user') {
            header('Location: dashboard.php');
        }
    } else {
        $login_message = "Akun tidak ditemukan";
    }
    $db->close();
}

// Sign Up
$register_message = "";
if (isset($_POST['signUp'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hash_password = hash('sha256', $password);

    try {
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hash_password', 'user')";

        if ($db->query($sql)) {
            $register_message = "Akun berhasil dibuat, Silahkan Login";
        } else {
            $register_message = "Gagal membuat akun";
        }
    } catch (mysqli_sql_exception) {
        $register_message = 'Username sudah ada';
    }
    $db->close();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container" id="container">
        <!-- Sign Up -->
        <?php if (!empty($login_message)) : ?>
            <script>
                alert("<?= $login_message ?>");
            </script>
        <?php endif; ?>
        <div class="form-container sign-up-container">
            <form action="#" method="post">
                <h1>Create Account</h1>
                <input type="text" placeholder="Name" name="username" />
                <input type="password" placeholder="Password" name="password" />
                <button name="signUp">Sign Up</button>
            </form>
        </div>

        <!-- Sign In -->
        <?php if (!empty($register_message)) : ?>
            <script>
                alert("<?= $register_message ?>");
            </script>
        <?php endif; ?>
        <div class="form-container sign-in-container">
            <form action="#" method="post">
                <h1>Sign in</h1>
                <input type="text" placeholder="Name" name="username" />
                <input type="password" placeholder="Password" name="password" />
                <a href="#">Forgot your password?</a>
                <button name="signIn">Sign In</button>
            </form>
        </div>

        <!-- Side Bar -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start journey with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>
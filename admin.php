<?php

session_start();

if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div>
        <h1>Selamat Datang <?= $_SESSION["username"]; ?> Di Halaman Admin</h1>
        <form action="#" method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>

</html>
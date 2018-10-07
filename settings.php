<?php
    require 'app/db.php';
    session_start();

    if($_SESSION['logged_in'] == true)
    {
        header("location: index.php");
    }

    $ID = $_SESSION['user_id'];
    $sql = $mysqli->query("SELECT * FROM users WHERE id='$ID");
    $user = $sql->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>
    <?php require 'components/head.php' ?>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <div class="container"> 
    </div>
    <?php require 'components/footer.php' ?>
</body>
</html>
<?php
    require 'app/db.php';
    session_start();
    if($_GET['test'] != 1)
    {
        header("location: index.php");
    }
    /*$imagehash = $_GET['img'];
    $result = $mysqli->query("SELECT images.*, users.username, users.id FROM images JOIN users ON users.id = images.user_id WHERE imagehash='$imagehash'");
    $info = $result->fetch_assoc();
    var_dump($info);*/

    echo $_SESSION['user_id'] . " => " . $_SESSION['username'] . " => Logged in: " . $_SESSION['logged_in'] . "ADMIN: " . $_SESSION['admin'];
    die();

    $result = $mysqli->query("SELECT * FROM images");

    while($row = mysqli_fetch_assoc($result))    
    {  
        var_dump($row);
    } 
?>
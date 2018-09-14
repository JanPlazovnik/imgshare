<?php
    require 'app/db.php';
    if($_GET['test'] != 1)
    {
        header("location: index.php");
    }
    /*$imagehash = $_GET['img'];
    $result = $mysqli->query("SELECT images.*, users.username, users.id FROM images JOIN users ON users.id = images.user_id WHERE imagehash='$imagehash'");
    $info = $result->fetch_assoc();
    var_dump($info);*/

    $result = $mysqli->query("SELECT * FROM images");

    while($row = mysqli_fetch_assoc($result))    
    {  
        var_dump($row);
    } 
?>
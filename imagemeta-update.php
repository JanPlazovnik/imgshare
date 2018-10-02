<?php
    require 'app/db.php';
    session_start();

    $imagehash = $mysqli->escape_string($_POST['imagehash']);
    $title = $mysqli->escape_string($_POST['title']);  
    $desc = $mysqli->escape_string($_POST['desc']);

    $sql = $mysqli->query("SELECT * FROM images WHERE imagehash='$imagehash'");
    $user = $sql->fetch_assoc();

    if($_SESSION['admin'] == 1 || $_SESSION['user_id'] == $user['user_id'])
        $mysqli->query("UPDATE images SET image_title='$title', image_description='$desc' WHERE imagehash='$imagehash'");
?>
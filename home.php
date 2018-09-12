<?php
    require 'app/db.php';
    session_start();

    $result = $mysqli->query("SELECT * FROM images");
    $image = $result->fetch_assoc();
    $url = $image['imagehash'];
    $ext = $image['extension'];
    $title = $image['image_title'];
    $desc = $image['image_description'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php require 'components/head.php' ?>
</head>
<body>
    <?php require 'components/nav.php' ?>
</body>
</html>
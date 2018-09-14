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
    <title>Image thingy</title>
    <?php require 'components/head.php' ?>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <!-- top section-->
    <section class="intro">
        <div class="intro-text">
            <h1>Image thingy</h1>
            <p>Share your photos</p>
        </div>
    </section>
    <section id="photos">
        <img src="https://3c1703fe8d.site.internapcdn.net/newman/gfx/news/2018/europeslostf.jpg" style="width:100%">
    </section>
</body>
</html>
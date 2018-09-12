<?php
    require 'app/db.php';
    session_start();

    $imagehash = $_GET['img'];
    $result = $mysqli->query("SELECT * FROM images WHERE imagehash='$imagehash'");
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
    <title><?php echo $title?></title>
    <?php require 'components/head.php' ?>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <div class="centered">
        <?php if(isset($url)): ?>
            <div class="img-title">
                <p><?php echo $title ?></p>
            </div>
            <div class="img-box">
                <img src='images/<?php echo $url . "." . $ext?>'></img>
            </div>
            <div class="img-desc">
                <p><?php echo $desc ?></p>
            </div>
        <?php else: ?>
            <p>No image found.</p>
        <?php endif ?>
    </div>
</body>
</html>
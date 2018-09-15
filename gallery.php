<?php
    require 'app/db.php';
    session_start();

    $imagehash = $_GET['img'];
    $result = $mysqli->query("SELECT images.*, users.username, users.id FROM images JOIN users ON users.id = images.user_id WHERE imagehash='$imagehash'");
    $info = $result->fetch_assoc();
    $url = $info['imagehash'];
    $ext = $info['extension'];
    $title = $info['image_title'];
    $desc = $info['image_description'];
    $author = $info['username'];
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
    <div style="margin-top: 100px" class="centered">
        <div class="img-area">
            <?php if(isset($url)): ?>
                <div class="img-header">
                    <div class="img-title">
                        <p><?php echo $title ?></p>
                    </div>
                    <div class="img-author">
                        <p>by <?php echo $author ?></p>
                    </div>
                </div>
                <div class="img-box">
                <img class="gallery-img" src='images/<?php echo $url . "." . $ext?>'></img>
                </div>
                <div class="img-desc">
                    <p><?php echo $desc ?></p>
                </div>
            <?php else: ?>
                <p>No image found.</p>
            <?php endif ?>
        </div>
    </div>
</body>
</html>


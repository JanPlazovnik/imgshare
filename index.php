<?php
    require 'app/db.php';
    session_start();

    /*$result = $mysqli->query("SELECT * FROM images");
    $image = $result->fetch_assoc();
    $url = $image['imagehash'];
    $ext = $image['extension'];
    $title = $image['image_title'];
    $desc = $image['image_description'];*/

    $result = $mysqli->query("SELECT images.*, users.username, users.id FROM images JOIN users ON users.id = images.user_id ORDER BY time_uploaded DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Imgix</title>
    <?php require 'components/head.php' ?>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <!-- top section-->
    <!--<section class="intro">
        <div class="intro-text">
            <h1>Imgix</h1>
            <p>Share your photos</p>
        </div>
    </section>-->
    <div style="margin-top: 80px" class="container">
        <?php
            while($row = mysqli_fetch_assoc($result))    
            {  
                echo "
                <a style='text-decoration: none' href='gallery.php?img=" . $row['imagehash'] . "'>
                    <div class='grid-item'>
                        <div class='img-header'>
                            <div class='img-title'>
                                <p>" . $row['image_title'] . "</p>
                            </div>
                            <div class='img-author'>
                                <p>by " . $row['username'] . "</p>
                            </div>
                        </div>
                        <div class='grid-imgbox'>
                            <img class='grid-image' src='images/" . $row['imagehash'] . "." . $row['extension'] . "'>
                        </div>
                        <br/>
                    </div>
                </a>"; 
            }
        ?>   
    </div>
    <?php require 'components/footer.php' ?>
</body>
</html>
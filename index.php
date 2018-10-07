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
    <meta content="Imgix" property="og:site_name">
    <meta content="Imgix" property="og:title">
    <meta content="Upload and share your photos." property="og:description">
    <title>Imgix</title>
    <?php require 'components/head.php' ?>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <div style="margin-top: 80px" class="container">
        <?php
            while($row = $result->fetch_assoc())    
            {  
                echo "<a style='text-decoration: none' href='gallery.php?img=" . $row['imagehash'] . "'>";
                    echo "<div class='grid-item'>";
                        echo "<div class='img-header'>";
                            echo "<div class='img-title'>";
                                echo "<p>" . $row['image_title'] . "</p>";
                            echo "</div>";
                            echo "<div class='img-author'>";
                                echo "<p>by " . $row['username'] . "</p>";
                            echo "</div>";
                        echo "</div>";
                        echo "<div class='grid-imgbox'>";
                            echo "<img class='grid-image' src='images/" . $row['imagehash'] . "." . $row['extension'] . "'>";
                        echo "</div>";
                        echo "<br/>";
                    echo "</div>";
                echo "</a>";
            }
        ?>   
    </div>
    <?php require 'components/footer.php' ?>
</body>
</html>
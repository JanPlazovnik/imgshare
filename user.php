<?php
    require 'app/db.php';
    session_start();

    $user = $mysqli->escape_string($_GET['user']);

    $result = $mysqli->query("SELECT images.*, users.username, users.id FROM images JOIN users ON users.id = images.user_id WHERE users.username = '$user' ORDER BY time_uploaded DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require 'components/head.php' ?>
    <title><?php echo $user?></title>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <!--<div style="margin-top: 80px; color: #ff6961" class="content">
        <h1 style="padding-left: 15px; padding-bottom: 15px"><?php echo $user?>'s pictures:</h1>
    </div>-->
    <div style="margin-top: 80px" class="container">
        <?php
            while($row = mysqli_fetch_assoc($result))    
            {  
                echo "
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
                        <a href='gallery.php?img=" . $row['imagehash'] . "'>
                            <img class='grid-image' src='images/" . $row['imagehash'] . "." . $row['extension'] . "'>
                        </a>
                    </div>
                </div>"; 
            }
        ?>   
    </div>  
    <?php require 'components/footer.php' ?>
</body>
</html>
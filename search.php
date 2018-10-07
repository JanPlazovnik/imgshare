<?php
    require 'app/db.php';
    session_start();

    $search = $mysqli->escape_string($_POST['query']);

    $images = $mysqli->query("SELECT * from images WHERE image_title LIKE '%$search%'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php require 'components/head.php' ?>
    <title><?php echo $search ?></title>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <div style="margin-top: 80px" class="container">
    <?php
        if(strlen($search) >= 1){
            $count = 0;
            $sql = $mysqli->query("SELECT images.*, users.username, users.id FROM images JOIN users ON users.id = images.user_id WHERE image_title LIKE '%$search%'");
            while($row = $sql->fetch_assoc()) 
            {  
                $count++;
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
                        echo "<a href='gallery.php?img=" . $row['imagehash'] . "'>"; 
                            echo "<img class='grid-image' src='images/" . $row['imagehash'] . "." . $row['extension'] . "'>"; 
                        echo "</a>"; 
                    echo "</div>"; 
                echo "</div>";
            }
            if($count === 0) 
            {
                echo "<div class='center'>";
                    echo "<p class='noresult'>No results.</p>";
                echo "</div>";
            }
        }
        else header("location: index.php");
    ?>   
    </div>
    <?php require 'components/footer.php' ?>
</body>
</html>
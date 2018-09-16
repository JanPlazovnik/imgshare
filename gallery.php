<?php
    require 'app/db.php';
    session_start();

    $imagehash = $mysqli->escape_string($_GET['img']);
    $result = $mysqli->query("SELECT images.*, users.username FROM images JOIN users ON users.id = images.user_id WHERE imagehash='$imagehash'");
    $info = $result->fetch_assoc();
    $imageid = $info['id'];
    $url = $info['imagehash'];
    $ext = $info['extension'];
    $title = $info['image_title'];
    $desc = $info['image_description'];
    $author = $info['username'];
    $userid = $info['user_id'];
    $id = $_SESSION['user_id'];

    $dellink = "gallery.php?img=" . $url . "&delete=1";

    $uploaded = date( 'd-m-Y H:i', strtotime($info['time_uploaded']) );

    if(($_GET['delete'] == 1) && ($id == $userid))
    {
        $path = "images/" . $url . "." . $ext;
        $sql = "DELETE FROM images WHERE imagehash='$url'";
        if($mysqli->query($sql))
        {
            if(unlink($path))
                echo "File deleted";
            else
                echo "File not deleted";
            header("location: index.php");
        }
        else 
            echo "db fucked up";
    }

    if(isset($_POST['submitcomment']))
    {
        $comment = htmlspecialchars(strip_tags($_POST['comment']));
        if(strlen($comment) > 250)
        {
            $error = "You have exceeded the comment length of 250 characters.";
        }
        else {
            $sql = "INSERT INTO comments (image_id, user_id, comment_text, time_created)" . "VALUES ('$imageid', '$id', '$comment', NOW())";
            
            if($mysqli->query($sql))
            {
                $success = "gj";
            }
            else {
                $error = "idiot";
            }
        }
    }
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
                        <p>by <a class="img-url" href="<?php echo 'user.php?user=' . $author?>"><?php echo $author ?></a> on <?php echo $uploaded ?></p>
                    </div>
                </div>
                <div class="img-box">
                <img class="gallery-img" src='images/<?php echo $url . "." . $ext?>'>
                </div>
                <?php if($id == $userid): ?>
                    <div class="img-controls">              
                        <a href="<?php echo $dellink?>">Delete</a>
                    </div>
                <?php endif; ?>  
                <div class="img-desc">
                    <p><?php echo $desc ?></p>
                </div>
            <?php else: ?>
                <p>No image found.</p>
            <?php endif ?>
        </div>
        <div class="comments">
            <?php if($_SESSION['logged_in'] == true): ?>
            <div class="new-comment">
                <?php if(isset($success)) { ?><p><?php echo $success?></p><?php }?>
                <?php if(isset($error)) { ?><p><?php echo $error?></p><?php }?>
                <form action="gallery.php?img=<?php echo $url?>" method="post" autocomplete="off" enctype="multipart/form-data">
                    <textarea class="input" placeholder="Write your comment" name="comment" maxlength="250" required></textarea>
                    <button class="button" type="submit" name="submitcomment">Submit</button>
                </form>
            </div>
            <?php elseif($_SESSION['logged_in'] == false): ?>
            <h2 class="comment-login">Log in to leave a comment.</h2>
            <?php  endif ?>
            <div <?php if($_SESSION['logged_in'] == true) { echo 'style="margin-top: 54px"'; } ?> class="all-comments">
                <?php
                    $result = $mysqli->query("SELECT comments.*, users.username FROM comments JOIN users ON users.id = comments.user_id WHERE image_id='$imageid' ORDER BY comments.time_created DESC");      
                    while($row = mysqli_fetch_assoc($result))    
                    {  
                        $commenter = $row['username'];
                        $when = date( 'd-m-Y H:i', strtotime($row['time_created']) );
                        echo "
                            <div class='comment-item'>
                                <div class='comment-author'>
                                    <p><a class='img-url' href='user.php?user=$commenter'>$commenter</a> on $when</p>
                                </div>
                                <div class='comment-content'>
                                    <p>" . $row['comment_text'] . "</p>
                                </div>
                            </div>";
                    }
                ?>   
            </div>
        </div>
    </div>
</body>
</html>
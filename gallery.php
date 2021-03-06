<?php
    require 'app/db.php';
    session_start();

    $imagehash = $mysqli->escape_string($_GET['img']);
    $result = $mysqli->query("SELECT images.*, users.username, users.admin FROM images JOIN users ON users.id = images.user_id WHERE imagehash='$imagehash'");
    $info = $result->fetch_assoc();

    $imageid = $info['id'];
    $url = $info['imagehash'];
    $ext = $info['extension'];
    $title = $info['image_title'];
    $desc = $info['image_description'];
    $author = $info['username'];
    $userid = $info['user_id'];
    if(isset($_SESSION['user_id']))
        $id = $_SESSION['user_id'];

    $errors = [];

    $dellink = "gallery.php?img=" . $url . "&delete=1";

    $uploaded = date( 'd.m.Y H:i', strtotime($info['time_uploaded']) );

    if(isset($_POST['submitcomment']))
    {
        $comment = htmlspecialchars(trim($_POST['comment']));
        
        if(strlen($comment) > 250)
        {
            $errors[] = "You have exceeded the comment length of 250 characters.";
        }
        else if($comment == "")
        {
            $errors[] = "Comment can't be empty.";
        }
        else {
            if($mysqli->query("INSERT INTO comments (image_id, user_id, comment_text, time_created)" . "VALUES ('$imageid', '$id', '$comment', NOW())"))
            {
                header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']);
            }

            else {trigger_error("ERROR:" . mysqli_error($mysqli), E_USER_ERROR);}

        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta content='http://<?php echo $_SERVER['HTTP_HOST']?>/imgshare/images/<?php echo $url . "." . $ext?>' property='og:image'>
    <?php require 'components/head.php' ?>
    <title><?php echo $title?></title>
    <script type="text/javascript">
        function removeComment(id) {
            $.ajax({
                type: "POST",
                url: "comment-delete.php",
                data: "comment_id=" + id,
                success: function(){
                    $("#cmnt" + id).remove();
                }
            });
        }

        function editComment(id) {
            var newText = $("#id" + id).html();
            $("#id" + id).replaceWith('<textarea class="input-edit" id="id'+id+'">' + newText + '</textarea>');
            $("#editComment" + id).replaceWith('<span id="saveComment' + id + '" onclick="saveComment(' + id + ')"><i class="icofont-save"></i></span>');
        }  
        
        function saveComment(id) {
            var newText = $("#id" + id).val();
            $("#id" + id).replaceWith('<p id="id' + id +'">' + newText + '</p>');
            $("#saveComment" + id).replaceWith('<span id="editComment' + id + '" class="img-icons" onclick="editComment(' + id + ')"><i class="icofont-edit"></i></span>');
            $.ajax({
                type: "POST",
                url: "comment-update.php",
                data: 
                {
                    "id": id,
                    "comment": newText
                }
            });
        }

        function removePost(imghash) {
            $.ajax({
                type: "POST",
                url: "image-delete.php",
                data: 
                {
                    imagehash: imghash,
                    path: <?php echo "'images/$imagehash" . "." . $ext . "'" ?>,
                },
                success: function() {
                    window.location.replace("index.php");
                }
            });
        }

        function editPost() {
            var newTitle = $("#title").html();
            $("#title").replaceWith('<input type="text" id="title" class="input-edit" value="' + newTitle + '" >');
            var newDesc = $("#desc").html();
            $("#desc").replaceWith('<textarea class="input-edit" id="desc">' + newDesc + '</textarea>');
            $("#edit").replaceWith('<span id="save" onclick="savePost()"><i class="icofont-save"></i></span>');
        }

        function savePost() {
            var newTitle = $("#title").val();
            $("#title").replaceWith('<p id="title">' + newTitle + '</p>');
            var newDesc = $("#desc").val();
            $("#desc").replaceWith('<p id="desc">' + newDesc + '</p>');
            $("#save").replaceWith('<span onclick="editPost()" id="edit"><i class="icofont-edit"></i></span>');
            $.ajax({
                type: "POST",
                url: "imagemeta-update.php",
                data: 
                {
                    imagehash: <?php echo "'$imagehash'" ?>,
                    "title": newTitle,
                    "desc": newDesc
                }
            });
        } 
    </script>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <div style="margin-top: 100px" class="centered">
        <div class="img-area">
            <?php if(isset($url)): ?>
            <div class="img-header">
                <div class="img-title">
                    <p id="title"><?php echo $title ?></p>
                </div>
                <div class="img-author">
                    <p>by <a class="img-url" href="<?php echo 'user.php?user=' . $author?>"><?php echo $author ?></a> on <?php echo $uploaded ?></p>
                </div>
            </div>
            <div class="img-box">
            <img class="gallery-img" src='images/<?php echo $url . "." . $ext?>'>
            </div>
            <?php if((isset($id) && $id == $userid) || isset($_SESSION['admin']) && $_SESSION['admin']): ?>
            <div class="img-controls">
                <span class="img-icons" onclick="removePost('<?php echo $imagehash?>')"><i class="icofont-trash"></i></span>
                <span id="edit" onclick="editPost()"><i class="icofont-edit"></i></span>
            </div>
            <?php endif; ?>  
            <div class="img-desc">
                <p id="desc"><?php echo $desc ?></p>
            </div>
            <?php else: ?>
            <p>No image found.</p>
            <?php endif ?>
        </div>
        <?php if(isset($url)): ?>
        <div class="comments">
            <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
            <div class="new-comment">
                <form action="gallery.php?img=<?php echo $url?>" method="post" autocomplete="off" enctype="multipart/form-data">
                    <textarea class="input" placeholder="Write your comment" name="comment" maxlength="250" required></textarea>
                    <button class="button" type="submit" name="submitcomment">Submit</button>
                </form>
            </div>
            <?php elseif(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == false): ?>
            <h3 class="comment-login">In order to comment you must first login.</h3>
            <?php  endif ?>
            <?php if(!empty($errors))
            {
                foreach ($errors as $error) {
                    echo "<p class='error'>" . $error . "</p>";
                }
            }
            ?>
            <div class="all-comments">
                <?php
                    $result = $mysqli->query("SELECT comments.*, users.username FROM comments JOIN users ON users.id = comments.user_id WHERE image_id='$imageid' ORDER BY comments.time_created DESC");      
                    while($row = mysqli_fetch_assoc($result))    
                    {  
                        $commenter = $row['username'];
                        $when = date( 'd.m.Y H:i', strtotime($row['time_created']) );
                        $commentId = $row['id'];
                        $user = $row['user_id'];
                        echo "<div id='cmnt$commentId' class='comment-item'>";
                            echo "<div class='comment-author'>";
                                echo "<p><a class='img-url' href='user.php?user=$commenter'>$commenter</a> on $when";     
                                if(isset($_SESSION['user_id']) && $user == $_SESSION['user_id'])
                                {
                                    echo " | <span class='img-icons' onclick='removeComment($commentId)'><i class='icofont-trash'></i></span>";
                                    echo " <span class='img-icons' id='editComment$commentId' onclick='editComment($commentId)'><i class='icofont-edit'></i></span></p>";
                                }
                            echo "</div>";           
                            echo "<div class='comment-content'>";     
                                echo "<p id='id$commentId'>" . $row['comment_text'] . "</p>";
                            echo "</div>";
                        echo "</div>";
                    }
                ?>   
            </div>
        </div>
        <?php endif ?>
    </div>
    <?php require 'components/footer.php' ?>
</body>
</html>
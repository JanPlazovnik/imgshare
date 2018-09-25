<?php
    require 'app/db.php';
    session_start();

    $commentId = $mysqli->escape_string($_POST['comment_id']);  
    $user = $_SESSION['user_id'];

    $result = $mysqli->query("SELECT * FROM comments WHERE id='$commentId'");
    echo mysqli_errno($mysqli);
    $comments = $result->fetch_assoc();
    if($comments['user_id'] == $user)
    {
        $sql = "DELETE FROM comments WHERE id='$commentId'";
        if($mysqli->query($sql)) 
        {
            echo "comment deleted";
        }
        else {
            echo "sql fail";
        }
    }
?>
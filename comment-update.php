<?php
    require 'app/db.php';
    session_start();

    $comment = $mysqli->escape_string($_POST['comment']);
    $id = $mysqli->escape_string($_POST['id']);

    $sql = $mysqli->query("SELECT * FROM comments WHERE id='$id'");
    $user = $sql->fetch_assoc();

    if($_SESSION['admin'] || $_SESSION['user_id'] == $user['user_id'])
        $mysqli->query("UPDATE comments SET comment_text='$comment' WHERE id='$id'") or trigger_error("ERROR:" . mysqli_error($mysqli), E_USER_ERROR);
?>
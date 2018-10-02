<?php
    require 'app/db.php';
    session_start();

    $imagehash = $mysqli->escape_string($_POST['imagehash']);
    $path = $mysqli->escape_string($_POST['path']);

    var_dump($imagehash);
    var_dump($path);
    var_dump($user);
    
    $result = $mysqli->query("SELECT * FROM images WHERE imagehash='$imagehash'");
    $user = $result->fetch_assoc();

    if((($_SESSION['user_id'] == $user['id']) || $_SESSION['admin']))
    {
        $sql = "DELETE FROM images WHERE imagehash='$imagehash'";
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
?>
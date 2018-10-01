<?php
    require 'app/db.php';

    $imagehash = $mysqli->escape_string($_POST['imagehash']);  
    $title = $mysqli->escape_string($_POST['title']);  
    $desc = $mysqli->escape_string($_POST['desc']);  

    //add user check or whatever

    $result = $mysqli->query("UPDATE images SET image_title='$title', image_description='$desc' WHERE imagehash='$imagehash'");
?>
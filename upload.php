<?php
    require 'app/db.php';

    session_start();

    if($_SESSION['logged_in'] == false)
    {
        header("location: login.php");
    }

    $currentDir = getcwd();
    $uploadDirectory = "/images/";

    $errors = []; // Store all errors

    $fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

    $fileName = $_FILES['imgfile']['name'];
    $fileSize = $_FILES['imgfile']['size'];
    $fileTmpName  = $_FILES['imgfile']['tmp_name'];
    $fileType = $_FILES['imgfile']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

    $title = $_POST['title'];
    $description = $_POST['description'];
    $imagehash = bin2hex(random_bytes(5));

    $uploadPath = $currentDir . $uploadDirectory . basename($fileName); 

    if (isset($_POST['submit'])) {

        if (! in_array($fileExtension,$fileExtensions)) {
            $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
        }

        if ($fileSize > 2000000) {
            $errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
        }

        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                echo "The file " . basename($fileName) . " has been uploaded";
                rename('images/' . basename($fileName), 'images/' . $imagehash . "." . $fileExtension);
                $sql = "INSERT INTO images (user_id, imagehash, extension, image_title, image_description, time_uploaded)". "VALUES ('{$_SESSION['user_id']}', '$imagehash', '$fileExtension', '$title', '$description', NOW())";  
                if($mysqli->query($sql))
                {
                    echo "<p>DB Successful</p>";
                } else {
                    echo "<p>DB Error</p>";
                }               
            } else {
                echo "An error occurred somewhere. Try again or contact the admin";
            }
        } else {
            foreach ($errors as $error) {
                echo $error . "These are the errors" . "\n";
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
    <title>Image upload</title>
    <?php require 'components/head.php' ?>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <div class = "centered">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            Select image to upload:
            <input type="file" name="imgfile" id="imgfile">
            <br/>
            <label>Image title:</label>
            <input type="text" name="title" required />
            <br/>
            <label>Image description:</label>
            <input type="text" name="description" required />      
            <br/>  
            <input type="submit" value="Upload" name="submit">
        </form>
        <br/><br/>
        <?php if(isset($errmsg)){ ?><span><?php echo $errmsg; ?></span><?php } ?>
        <?php if(isset($succmsg)){ ?><span><?php echo $succmsg; ?></span><?php } ?>
    </div>
</body>
</html>
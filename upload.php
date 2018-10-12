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

    $fileExtensions = ['jpeg','jpg','png', 'gif']; // Get all the file extensions

    $fileName = $_FILES['imgfile']['name'];
    $fileSize = $_FILES['imgfile']['size'];
    $fileTmpName  = $_FILES['imgfile']['tmp_name'];
    $fileType = $_FILES['imgfile']['type'];
    $fileExtension = strtolower(end(explode('.',$fileName)));

    $title = $_POST['title'];
    if(strlen($_POST['description']) > 0)
        $description = $_POST['description'];
    else
        $description = "";
    $imagehash = bin2hex(random_bytes(5));

    $uploadPath = $currentDir . $uploadDirectory . basename($fileName); 

    if(isset($_POST['submit'])) 
    {
        if(!in_array($fileExtension, $fileExtensions)) {
            $errors[] = "Invalid format. Use only .jpeg, .jpg, .png or .gif format.";
        }
        if($fileSize > 2000000) {
            $errors[] = "File exceeds the maximum size limit of 2MB.";
        }
        else {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
            if ($didUpload) 
            {
                echo "The file " . basename($fileName) . " has been uploaded";
                rename('images/' . basename($fileName), 'images/' . $imagehash . "." . $fileExtension);
                $sql = "INSERT INTO images (user_id, imagehash, extension, image_title, image_description, time_uploaded)". "VALUES ('{$_SESSION['user_id']}', '$imagehash', '$fileExtension', '$title', '$description', NOW())";  
                if($mysqli->query($sql))
                {   
                    $imgurl = "gallery.php?img=" . $imagehash;
                    header("location: " . $imgurl);
                } 
                else {
                    $errors[] = "Couldn't execute the query.";
                }               
            } 
            else {
                $errors[] = "An error occurred somewhere. Try again or contact the admin";
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
    <div class="center">
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="imgfile" id="imgfile" accept=".jpeg, .jpg, .png, .gif">
            <label class="label-upload noselect" for="imgfile">Choose photo</label>         
            <input class="input" type="text" name="title" placeholder="Title" required />         
            <input class="input" type="text" placeholder="Description" name="description" />       
            <button class="button" type="submit" name="submit">Upload</button>
        </form>
        <?php if(isset($errmsg)){ ?><span><?php echo $errmsg; ?></span><?php } ?>
        <?php if(isset($succmsg)){ ?><span><?php echo $succmsg; ?></span><?php } ?>
        <?php if(!empty($errors))
        {
            foreach ($errors as $error) {
                echo "<p class='error'>" . $error . "</p>";
            }
        }
        ?>
    </div>
    <?php require 'components/footer.php' ?>
</body>
</html>
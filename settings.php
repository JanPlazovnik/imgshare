<?php
    require 'app/db.php';
    session_start();

    if(!$_SESSION['logged_in'])
    {
        header("location: index.php");
    }

    $id = $_SESSION['user_id'];
    $sql = $mysqli->query("SELECT * FROM users WHERE id='$id'") or trigger_error("ERROR:" . mysqli_error($mysqli), E_USER_ERROR);;
    $user = $sql->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>
    <?php require 'components/head.php' ?>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <div class="center">
        <?php if(isset($_GET['success'])):?>
        <?php if($_GET['success'] == 1):?>
        <div id="success">
            <p>Changes saved.</p>
        </div>
        <?php endif?>
        <?php if($_GET['success'] == 0):?>
        <div id="error">
            <p>Changes not saved.</p>
        </div>
        <?php endif ?>
        <?php endif ?>
        <form action="update-settings.php" method="post" autocomplete="off" enctype="multipart/form-data">
            <p>Email</p>
            <input value="<?php echo $user['email'] ?>" type="text" name="email"/>
            <label>Password</label>
            <input type="password" name="password"/>
            <button type="submit" name="save">Save settings</button>
        </form>
    </div>
    <?php require 'components/footer.php' ?>
</body>
</html>
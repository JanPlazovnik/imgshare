<?php
    require 'app/db.php';

    session_start();

    if($_SESSION['logged_in'] == true)
    {
        header("location: index.php");
    }

    if(isset($_POST['username']) && isset($_POST['password']))
    {
        $username = $_POST['username'];
        $result = $mysqli->query("SELECT * FROM users WHERE username='$username'");

        if($result->num_rows == 0)
        {
            $usererror = "User doesn't exist!";
        }
        else {
            $user = $result->fetch_assoc();
            /*var_dump($user);
            die();*/
            if(password_verify($_POST['password'], $user['password']))
            {
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['admin'] = $user['admin'];
                header("location: index.php");
            }
            else {
                $passerror = "Incorrect password!";
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
    <title>Login</title>
    <?php require 'components/head.php' ?>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <div class="center" style="text-align: center">
        <form action="login.php" method="post" autocomplete="off" enctype="multipart/form-data">
            <input class="input" placeholder="Username" type="text" name="username" required/>
            <?php if(isset($usererror)){ ?><span style="color: #bbb; text-align: center"><?php echo $usererror; ?></span><?php } ?>
            <input class="input" placeholder="Password" type="password" name="password" required/>
            <?php if(isset($passerror)){ ?><span style="color: #bbb; text-align: center"><?php echo $passerror; ?></span><?php } ?>
            <button class="button" type="submit" name="login">Login</button>
        </form>
        <div class="register">
            <a href="register.php">Create an account</a>
        </div>
    </div>
    <?php require 'components/footer.php' ?>
</body>
</html>
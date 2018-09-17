<?php
    require 'app/db.php';

    session_start();
   
    if($_SESSION['logged_in'] == true)
    {
        header("location: index.php");
    }

    if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']))
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        if (strlen($password) < 6) {
            $passerror = 'Password must be at least 6 characters long.';
        }
        else if((strlen($username) < 4) || (strlen($username) > 16))
        {
            $usererror = 'Username must be betwen 4 and 16 characters long.';
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailerror = "Invalid email format";
        }
        else {
            $username = $mysqli->escape_string(trim($_POST['username']));
            $email = $mysqli->escape_string(trim($_POST['email']));
            $password = $mysqli->escape_string(password_hash(trim($_POST['password']), PASSWORD_BCRYPT));

            $result = $mysqli->query("SELECT * FROM users WHERE username='$username'") or die($mysqli->error());
            
            $user = $result->fetch_assoc();

            if($result->num_rows > 0)
            {
                $errmsg = "Account already exists!";
            }
            else {
                $sql = "INSERT INTO users (username, password, email, time_created)". "VALUES ('$username', '$password', '$email', NOW())";      
                if($mysqli->query($sql))
                {
                    $succmsg = "Account created!";
                    header("location: login.php");
                }
                else {
                    $errmsg = "Account creation failed!";
                }
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
    <title>Register</title>
    <?php require 'components/head.php' ?>
</head>
<body>
    <?php require 'components/nav.php' ?>
    <div class="center" style="text-align: center">
        <form action="register.php" method="post" autocomplete="off" enctype="multipart/form-data"> 
            <input class="input" type="text" placeholder="Username" name="username" required/>
            <?php if(isset($usererror)){ ?><span style="color: #bbb; text-align: center"><?php echo $usererror; ?></span><?php } ?>
            <input class="input" type="text" placeholder="Email" name="email" required/>
            <?php if(isset($emailerror)){ ?><span style="color: #bbb; text-align: center"><?php echo $emailerror; ?></span><?php } ?>
            <input class="input" type="password" placeholder="Password" name="password" required/>
            <?php if(isset($passerror)){ ?><span style="color: #bbb; text-align: center"><?php echo $passerror; ?></span><?php } ?>
            <button class="button" type="submit" name="register">Register</button>
        </form>
        <?php if(isset($errmsg)){ ?><span style="color: #bbb; text-align: center"><?php echo $errmsg; ?></span><?php } ?>
        <?php if(isset($succmsg)){ ?><span style="color: #bbb; text-align: center"><?php echo $succmsg; ?></span><?php } ?>
    </div>
    <?php require 'components/footer.php' ?>
</body>
</html>
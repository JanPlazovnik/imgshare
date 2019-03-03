<?php
    require 'app/db.php';

    session_start();

    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
    {
        header("location: index.php");
    }
    $errors = [];
    if(isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']))
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters long.';
        }
        else if((strlen($username) < 4) || (strlen($username) > 16))
        {
            $errors[] = 'Username must be betwen 4 and 16 characters long.';
        }
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        {
            $errors[] = "Invalid email format";
        }
        else {
            $username = $mysqli->escape_string(trim($_POST['username']));
            $email = $mysqli->escape_string(trim($_POST['email']));
            $password = $mysqli->escape_string(password_hash(trim($_POST['password']), PASSWORD_BCRYPT));

            $result = $mysqli->query("SELECT * FROM users WHERE username='$username'") or die($mysqli->error());
            
            $user = $result->fetch_assoc();

            if($result->num_rows > 0)
            {
                $errors[] = "Account already exists!";
            }
            else {
                $sql = "INSERT INTO users (username, password, email, time_created)". "VALUES ('$username', '$password', '$email', NOW())";      
                if($mysqli->query($sql))
                {
                    $succmsg = "Account created!";
                    header("location: login.php");
                }
                else {
                    $errors[] = "Account creation failed!";
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
            <input class="input" type="text" placeholder="Username (min. 4 and max. 16 characters)" name="username" required/>
            <input class="input" type="text" placeholder="Email" name="email" required/>
            <input class="input" type="password" placeholder="Password (min. 6 characters)" name="password" required/>
            <button class="button" type="submit" name="register">Register</button>
        </form>
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
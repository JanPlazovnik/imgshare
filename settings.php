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
        <div class="settings">
            <div class="settings-menu noselect">
                <div class="settings-email inlblock settings-item">
                    <span><i class="icofont-email"></i> Email</span>
                </div>
                <div class="settings-password inlblock settings-item">
                    <span><i class="icofont-ui-password"></i> Password</span>
                </div>
            </div>
            <div class="settings-content">
                <div class="settings-content-email">
                    <form action="settings-email.php" method="post" autocomplete="off" enctype="multipart/form-data">
                        <p>Enter your new email</p>
                        <input class="input" type="text" name="email" placeholder="Email" required>
                        <button class="button" type="submit" name="submitEmail">Submit</button>
                    </form>
                </div>
                <div class="settings-content-password settings-form-hidden">
                    <form action="settings-password.php" method="post" autocomplete="off" enctype="multipart/form-data">
                        <p>Enter your current password</p>
                        <input class="input" type="password" name="currentPassword" placeholder="Old password" required>
                        <p>Enter your new password</p>
                        <input class="input" type="password" name="newPassword" placeholder="New password" required>
                        <button class="button" type="submit" name="submitPassword">Submit</button>
                    </form>                   
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $(".settings-email").on("click", function(){
        $(".settings-content-email").removeClass("settings-form-hidden");
        $(".settings-content-password").addClass("settings-form-hidden");
    });
    $(".settings-password").on("click", function(){
        $(".settings-content-password").removeClass("settings-form-hidden");
        $(".settings-content-email").addClass("settings-form-hidden");    
    });
    </script>
    <?php require 'components/footer.php' ?>
</body>
</html>


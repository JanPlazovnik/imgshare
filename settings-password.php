
<?php
    require 'app/db.php';
    session_start();

    $oldPassword = $mysqli->escape_string($_POST['oldPassword']);
    $newPassword = $_POST['newPassword'];
    $userid = $_SESSION['user_id'];

    $result = $mysqli->query("SELECT * FROM users WHERE id='$userid'");
    $user = $result->fetch_assoc();

    if(strlen($newPassword) > 6 && isset($oldPassword) && isset($newPassword) && password_verify($oldPassword, $user['password']))
    {
        $password = $mysqli->escape_string(password_hash(trim($_POST['newPassword']), PASSWORD_BCRYPT));
        $mysqli->query("UPDATE users SET password='$password' WHERE id='$userid'") or trigger_error("ERROR:" . mysqli_error($mysqli), E_USER_ERROR);
        header("location: settings.php?success=1");
    }
    else {
        header("location: settings.php?success=0");
    }
?>
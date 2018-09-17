<div class="topnav">
    <div class="content">
        <a class="active" href="index.php">Imgix</a>
        <a href="upload.php">Upload</a>
        <?php if($_SESSION['logged_in'] == true): ?>
        <div style="float: right">
            <a href="<?php echo 'user.php?user=' . $_SESSION['username']?>"><?php echo $_SESSION['username'] ?></a>
            <a href="logout.php">Sign out</a>
        </div>
        <?php else: ?>
        <div style="float: right">
            <a href="login.php">Sign in</a>
            <a href="register.php">Register</a>
        </div>
        <?php endif ?>
    </div>
</div>
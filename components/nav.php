<div class="topnav">
    <div class="content">
        <a class="active" href="index.php">Imgix</a>
        <a href="upload.php">Upload</a>
        <?php if($_SESSION['logged_in'] == true): ?>
            <a style="float: right" href="logout.php">Sign out</a>
        <?php else: ?>
            <a style="float: right" href="login.php">Sign in</a>
            <a style="float: right" href="register.php">Register</a>
        <?php endif ?>
    </div>
</div>
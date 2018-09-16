<div class="topnav">
    <div class="content">
        <a class="active" href="index.php">Imgix</a>
        <a href="upload.php">Upload</a>
        <?php if($_SESSION['logged_in'] == true): ?>
            <a class="right" href="logout.php">Sign out</a>
            <a class="right" href="<?php echo 'user.php?user=' . $_SESSION['username']?>"><?php echo $_SESSION['username'] ?></a>
        <?php else: ?>
            <a class="right" href="login.php">Sign in</a>
            <a class="right" href="register.php">Register</a>
        <?php endif ?>
    </div>
</div>
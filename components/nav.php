<div class="topnav noselect">
    <div class="content">
        <a class="navlink active" href="index.php">Imgix</a>
        <a class="navlink" href="upload.php"><i class="icofont-upload-alt"></i> Upload</a>
        <form class="search-form" action="search.php" method="post" enctype="multipart/form-data">
            <input class="input-search" type="text" name="query" placeholder="Search" required />   
            <button class="navlink searchbtn"><i class="icofont-search"></i></button>           
        </form>
        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true): ?>
        <div style="float: right">
            <div class="dropdown">
            <button class="dropbtn"><i class="icofont-ui-user"></i><i class="icofont-caret-down"></i></button>
            <div class="dropdown-content">
                <a href="<?php echo 'user.php?user=' . $_SESSION['username']?>"><i class="icofont-ui-user"></i> <?php echo $_SESSION['username']?></a>
                <a href="settings.php"><i class="icofont-settings"></i> Settings</a>
                <a href="logout.php"><i class="icofont-logout"></i> Sign out</a>
            </div>
            <script type="text/javascript">
            $(".dropbtn").click(function(){
                $(".dropdown-content").toggle();
            });
            </script>
        </div>
        </div>
        <?php else: ?>
        <div style="float: right">
            <a class="navlink" href="login.php"><i class="icofont-login"></i> Sign in</a>
        </div>
        <?php endif ?>
    </div>
</div>
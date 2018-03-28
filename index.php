<!DOCTYPE html>
<!--
/* 
 *Autoren: 	David Dittmann & Johannes Neustädter
 *Datum:	12.03.2018
 *Version:	1.0
 */
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="./res/css/style.css">
        <?php
            $configs=include("config.php");
            $host=$configs->host;
            $db=$configs->db;
            $db_user=$configs->db_user;
            $db_pass=$configs->db_pass;
        ?>
        <title></title>
    </head>
    <body>
        <div id="header" class="<?php echo $configs->class_header;?>">
            <?php
            include("header.php");
            ?>
            <div id="login" class="<?php echo $configs->class_login;?>">
                <?php
                include("login.php");
                ?>
            </div>
        </div>
        <div id="nav" class="<?php echo $configs->class_nav;?>">
            <?php
            include("navi.php");
            ?>
        </div>
        <div id="content" class="<?php echo $configs->class_content;?>">
            <?php
            include("content.php");
            ?>
        </div>
        <div id="footer" class="<?php echo $configs->class_footer;?>">
            <?php
            include("footer.php");
            ?>
        </div>
    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="res/js/js_scripts.js"></script>
    <script src="res/js/upload_ajax.js" type="text/javascript"></script>
    </body>
</html>

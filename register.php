<?php
    //echo "Hier steht was zum registrieren";
if(isset($_GET['register']))
{?>
<form action="?reg_db=1" onsubmit="return checkEingaben();" method="POST">
    <div class="<?php echo $configs->class_login_text;?>">
        Benutzername:
    </div>
    <div class="<?php echo $configs->class_login_input;?>">
        <input id="uname" class="reg_input" type="text" name="username" required>
    </div>
    <div class="<?php echo $configs->class_login_text;?>">
        Vorname:
    </div>
    <div class="<?php echo $configs->class_login_input;?>">
        <input id="vname" class="reg_input" type="text" name="vorname" required>
    </div>
    <div class="<?php echo $configs->class_login_text;?>">
        Nachname:
    </div>
    <div class="<?php echo $configs->class_login_input;?>">
        <input id="nname" class="reg_input" type="text" name="nachname" required>
    </div>
    <div class="<?php echo $configs->class_login_text;?>">
        Email Adresse:
    </div>
    <div class="<?php echo $configs->class_login_input;?>">
        <input id="mail" class="reg_input" type="email" name="mail" required>
    </div>
    <div class="<?php echo $configs->class_login_text;?>">
        Passwort:
    </div>
    <div class="<?php echo $configs->class_login_input;?>">
        <input id="pwd" class="reg_input" type="password" name="password" required>
    </div>
    <div class="<?php echo $configs->class_login_button;?>">
        <input class="reg_submit" type="submit" value="Absenden">
    </div>
</form>
<?php
}
elseif(isset($_GET['reg_db']))
{
    $uname=$_POST['username'];
    $vname=$_POST['vorname'];
    $nname=$_POST['nachname'];
    $mail=$_POST['mail'];
    $pwd=$_POST['password'];
    
    $pwmd5=md5($pwd);
    
    $dbobject = new mysqli($host, $db_user, $db_pass, $db);
    if(mysqli_connect_errno()==0)   //DB-Connection OK
    {
        echo '<script>console-log("DB CONNECTION -> OK");</script>';
        $qr='insert into user (`username`,`vorname`,`nachname`,`email`,`pwd`) '
                        . 'values ("'.$uname.'","'.$vname.'","'.$nname.'","'.$mail.'","'.$pwmd5.'")';
        $result=$dbobject->query($qr);

        if($result===true)
        {
            echo '<script type="text/javascript">alert("Sie wurden erfolgreich registriert!");</script>';
            echo '<script>console-log("Insert into DB -> OK");</script>';
            echo '<script type="text/javascript">window.location.href = "index.php"</script>';
        }
        else
        {
            echo '<script type="text/javascript">alert("Registrierung fehlgeschlagen!");</script>';
            echo '<script>console-log("Eintrag in DB fehlgeschlagen");</script>';
            echo '<script type="text/javascript">window.location.href = "index.php?reg_db=1"</script>';
        }
    }
    else
        echo '<script type="text/javascript">alert("DATENBANKVERBINDUNG NICHT MÖGLICH");</script>';
}?>
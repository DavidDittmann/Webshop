<?php
    //echo "Hier steht was zum registrieren";
if(isset($_GET['register']))
{?>
<p>
Hier können Sie sich für den WT-Webshop registrieren. Folgende Bedingungen müssen dabei erfüllt sein:<br>
<br>
-) Alle Felder sind Pflichtangaben<br>
-) Ein Benutzername muss aus mindestens 3 Zeichen bestehen<br>
-) Ein Passwort ist mindestens 8 Zeichen lang, wobei mindestens jeweils eines ein Großbuchstabe bzw. Sonderzeichen ist<br>
</p>

<br><br>

<form action="?reg_db=1" onsubmit="return checkEingaben();" method="POST">
    <div class="<?php echo $configs->class_reg_text;?>">
        Benutzername:
    </div>
    <div class="<?php echo $configs->class_reg_input;?>">
        <input id="uname" class="reg_input" type="text" name="username" required>
    </div>
    <div class="<?php echo $configs->class_reg_text;?>">
        Vorname:
    </div>
    <div class="<?php echo $configs->class_reg_input;?>">
        <input id="vname" class="reg_input" type="text" name="vorname" required>
    </div>
    <div class="<?php echo $configs->class_reg_text;?>">
        Nachname:
    </div>
    <div class="<?php echo $configs->class_reg_input;?>">
        <input id="nname" class="reg_input" type="text" name="nachname" required>
    </div>
    <div class="<?php echo $configs->class_reg_text;?>">
        Email Adresse:
    </div>
    <div class="<?php echo $configs->class_reg_input;?>">
        <input id="mail" class="reg_input" type="email" name="mail" required>
    </div>
    <div class="<?php echo $configs->class_reg_text;?>">
        Passwort:
    </div>
    <div class="<?php echo $configs->class_reg_input;?>">
        <input id="pwd" class="reg_input" type="password" name="password" required>
    </div>
    <div class="<?php echo $configs->class_reg_button;?>">
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
        }
        else
        {
            echo '<script type="text/javascript">alert("Registrierung fehlgeschlagen!");</script>';
            echo '<script>console-log("Eintrag in DB fehlgeschlagen");</script>';
        }
		
		echo '<script type="text/javascript">window.location.href = "index.php"</script>';
    }
    else
        echo '<script type="text/javascript">alert("DATENBANKVERBINDUNG NICHT MÖGLICH");</script>';
}?>

<script>
function checkEingaben()
{
    var uname = document.getElementById("uname").value;
    var vname = document.getElementById("vname").value;
    var nname = document.getElementById("nname").value;
    var Password = document.getElementById("pwd").value;
    var Email = document.getElementById("mail").value;

    var PassCheck = /^(?=.*\d)(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*._-]{8,}$/;
    var MatrCheck = /^[0-9]{10}$/;
    var EmailCheck = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,5}$/;
    var Error=0;	

    if(uname.length<3 || uname.length>20)
    {
        document.getElementById("uname").style.border = "2px solid red";
        window.alert("Username muss mind. 3, aber max. 20 Zeichen lang sein!");
        Error=1;
    }
    else
        document.getElementById("uname").style.border = "2px solid black";

    if(vname.length<1 || vname.length>20)
    {
        document.getElementById("vname").style.border = "2px solid red";
        window.alert("Username muss mind. 1, aber max. 20 Zeichen lang sein!");
        Error=1;
    }
    else
        document.getElementById("vname").style.border = "2px solid black";

    if(nname.length<1 || nname.length>20)
    {
        document.getElementById("nname").style.border = "2px solid red";
        window.alert("Username muss mind. 1, aber max. 20 Zeichen lang sein!");
        Error=1;
    }
    else
        document.getElementById("nname").style.border = "2px solid black";


    if(Password.match(PassCheck))   
    {    
        document.getElementById("pwd").style.border = "2px solid black";
    }  
    else  
    {   
        alert("Passwort inkorrekt! Mind. 8 Zeichen davon 1 Grossbuchstabe, 1 Sonderzeichen und 1 Zahl!");
        document.getElementById("pwd").style.border = "2px solid red";
        Error=1;		
    }

    if(Email.match(EmailCheck))   
    {    
        document.getElementById("mail").style.border = "2px solid black";
    }  
    else  
    {   
        alert("Email ist falsch!");
        document.getElementById("mail").style.border = "2px solid red";
        Error=1;		
    }

    if(Error==1)
        return false;
    else
        return true;
}
</script>
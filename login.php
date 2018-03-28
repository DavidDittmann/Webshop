<?php
/* 
 *Autoren: 	David Dittmann & Johannes Neustädter
 *Datum:	12.03.2018
 *Version:	1.0
 */
 
    $cookiePath="/";
    $cookieExpire=time()+360000;

    // da funktioniert irgendwas überhaupt nicht... ich wurde wieder nach einer Zeit rausgeworfen und konnte mich nicht mehr anmelden und bin irgendwo dead (cookie expire könnte es sein)
    // da wir jetzt dann eh auf das fh anmelde dings umstellen müssen könnte es sein das wir das probem damit beheben. ansonst müssen wir da durchschauen da is irgendwo ein bug
    
    if(isset($_COOKIE["PHPSESSID"])&&!isset($_GET["logout"]))    //SESSION vorhanden
    {
		$user="anonym";
		if(isset($_COOKIE["User"]))
		{
			$user=$_COOKIE["User"];
		}
        echo '<div class="text-center">Logged in as <b>'.$user.'</b></div>';
        ?>
        <form action="?logout=1" method="POST">
            <input class="log_submit <?php echo $configs->class_login_button;?>" type="submit" value="Logout"/>
        </form>
        <?php
        //echo session_id();
    }
    elseif((!isset($_GET['login']))&&(!isset($_COOKIE["PHPSESSID"])))   //Nicht eingelogt und keine SESSION
    {                                                               //-->ANONYMER USER
?>

    <form action="?login=1" method="POST">
		<div class="<?php echo $configs->class_login_h2;?>">
			<h2> Mit FH Account anmelden </h2>
		</div>
		<div class="<?php echo $configs->class_login_text;?>">
			Benutzer:
		</div>
		<div class="<?php echo $configs->class_login_input;?>">
			<input class="log_input" type="text" name="user">
		</div>
		<div class="<?php echo $configs->class_login_text;?>">
			Passwort:
		</div>
		<div class="<?php echo $configs->class_login_input;?>">
			<input class="log_input" type="text" name="password"><br>
		</div>
		<div class="<?php echo $configs->class_login_button;?>">
			<input class="log_submit" type="submit" value="Login">
		</div>
    </form> 
<?php
    }
    elseif(isset($_GET['login']))    //LOGIN und noch keine SESSION
    {
        $user=$_POST["user"];
        $pass=$_POST["password"];
      
        if($user=="user"&&$pass=="1234") //LOGIN CHECK
        {        
            echo '<div class="text-center">"Logged in as "'.$user.'</div>';
            session_start();                                    //Session wird gestartet
            $_SESSION['User']=$user;
            setcookie("User",$user,$cookieExpire,$cookiePath); //Cookie 1 Stunde gültig
            setcookie("PHPSESSID",session_id(),$cookieExpire,$cookiePath);
            //echo '<script type="text/javascript">alert("Successful login");</script>';
        }     
        else                                                //Login failed
        {
            echo '<script type="text/javascript">alert("Login failed");</script>';
        }
        echo '<script type="text/javascript">window.location.href = "index.php"</script>';
    }
    if(isset($_GET['logout'])&&isset($_COOKIE["User"]))   //Wenn Logout gedrückt und Session vorhanden 
    {                                                       //-> SESSION Löschen
        session_unset();
        session_destroy();
        
        setcookie("User", "", time()-3600,$cookiePath);
        unset($_COOKIE['User']);
        setcookie("PHPSESSID", "", time()-3600,$cookiePath);
        unset($_COOKIE['PHPSESSID']);
		setcookie("Menu", "", time()-3600,$cookiePath);
        unset($_COOKIE['Menu']);
        
        echo '<script type="text/javascript">window.location.href = "index.php"</script>';
    }
    
?>





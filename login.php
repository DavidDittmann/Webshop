<?php
/* 
 *Autoren: 	David Dittmann & Johannes Neustädter
 *Datum:	12.03.2018
 *Version:	1.0
 */

    $cookiePath="/";
    $cookieExpire=time()+36000;
    
    if(isset($_COOKIE["PHPSESSID"])&&!isset($_GET["logout"]))    //SESSION vorhanden
    {
		if(isset($_COOKIE["User"])&&$_COOKIE["User"]!="anonym")
		{
			$VN=$_COOKIE["Vorname"];
                        $NN=$_COOKIE["Nachname"];
		}
        echo '<div class="text-center">Hallo: '.$VN." ".$NN.'</div>';
        ?>
        <form action="?logout=1" method="POST">
            <input class="log_submit <?php echo $configs->class_login_button;?>" type="submit" value="Logout"/>
        </form>
        <?php
        //echo session_id();
    }
    elseif((!isset($_GET['login']))&&(!isset($_COOKIE["PHPSESSID"])))   //Nicht eingelogt und keine SESSION
    {                                                               //-->ANONYMER USER
        $user="anonym";
        setcookie("User",$user,$cookieExpire,$cookiePath);
    ?>
    <div id="login_form">
        <form action="?login=1" method="POST">
            <div class="<?php echo $configs->class_login_h2;?>">
                    <h2> Mit FH Account anmelden </h2>
            </div>
            <div class="<?php echo $configs->class_login_text;?>">
                    Benutzer:
            </div>
            <div class="<?php echo $configs->class_login_input;?>">
                    <input class="log_input" type="text" name="user" required>
            </div>
            <div class="<?php echo $configs->class_login_text;?>">
                    Passwort:
            </div>
            <div class="<?php echo $configs->class_login_input;?>">
                    <input class="log_input" type="password" name="password" required><br>
            </div>
            <div class="<?php echo $configs->class_login_button;?>">
                    <input class="log_submit" type="submit" value="Login">
            </div>

    <?php   if(isset($_GET['section'])){$sec=$_GET['section'];}else{$sec="nosec";} 
            echo '<input type="hidden" name="sec" value="'.$sec.'">';?>
        </form>
    </div>
    <div id="register">
        <form action="?register=1" method="POST">
            <div class="<?php echo $configs->class_login_button;?>">
                    <input class="log_submit" type="submit" value="Hier Registrieren!">
            </div>
        </form>
    </div>
<?php
    }
    elseif(isset($_GET['login']))    //LOGIN und noch keine SESSION
    {
        //echo '<script type="text/javascript">alert("Log");</script>';
        $user=$_POST["user"];
        $pass=$_POST["password"];
        $pwmd5=md5($pass);
        
        //GEGEN DATENBANK
        $dbobject = new mysqli($host, $db_user, $db_pass, $db);
        if(mysqli_connect_errno()==0)   //DB-Connection OK
        {
            echo '<script>console-log("DB CONNECTION -> OK");</script>';
            $qr='select `username`, `pwd`, `vorname`, `nachname` from user where `username`="'.$user.'" and `pwd`="'.$pwmd5.'"';
            $result=$dbobject->query($qr);

            if($result && $result->num_rows)    //EIntrag gefunden in DB
            {   //Eintrag in DB gefunden
                //echo "result was true - success";
                echo '<script>console-log("DB SELECT -> OK");</script>';
                $VN=$result->vorname;
                $NN=$result->nachname;
                session_start();                                    //Session wird gestartet
                $_SESSION['User']=$user;
                setcookie("Vorname",$VN,$cookieExpire,$cookiePath);
                setcookie("Nachname",$NN,$cookieExpire,$cookiePath);
                setcookie("User",$user,$cookieExpire,$cookiePath); //Cookie 1 Stunde gültig
                setcookie("PHPSESSID",session_id(),$cookieExpire,$cookiePath);

                $site=$_POST['sec'];
                if($site=="galerie_nologin")
                    echo '<script type="text/javascript">window.location.href = "index.php?section=galerie"</script>';
                elseif($site!="nosec")
                    echo '<script type="text/javascript">window.location.href = "index.php?section='.$site.'"</script>';
                else
                    echo '<script type="text/javascript">window.location.href = "index.php"</script>';
            }
            else
            {   //Kein Eintrag in DB gefunden
                //echo "result was false";
                //MIT LDAP versuchen
                echo '<script>console-log("DB SELECT -> FALSE, TRY LDAP");</script>';
                $ldapserver=$configs->ldapserver;
                $searchbase=$configs->searchbase;

                $user = strtolower($user);
                $ds=ldap_connect($ldapserver);
                if(!$ds){echo "Connect-Error to ldapserver"; exit;}

                ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);


                $ldapbind=false;
                if(ldap_start_tls($ds)) // verschlüsselte Verbindung verwenden
                    $dn = "ou=People,".$searchbase;  // wo wird gesucht?
                $ldapbind = @ldap_bind($ds,"uid=".$user.",".$dn,$pass);
                if ($ldapbind) {
                    echo '<script>console-log("LDAP CONNECTION -> OK");</script>';
                        // LDAP search (Suche am gebundenen Knoten)
                    $filter="(uid=$user)";
                    $justthese = array("sn", "givenname", "mail"); // nur nach diesen Einträgen suchen
                    $sr=ldap_search($ds, $dn, $filter, $justthese); // Suche wird durchgeführt
                    $info = ldap_get_entries($ds, $sr);             // gefundene Einträge werden ausgelesen
                    //echo $info["count"]." entries returned\n<br>";
                    $data = $info[0][0];
                    $VN=$info[0][$data][0];
                    $data = $info[0][1];
                    $NN=$info[0][$data][0];    
                    $data = $info[0][2];
                    $Mail=$info[0][$data][0];
                    $is_ldap=true;

                    //$dbobject = new mysqli($host, $db_user, $db_pass, $db);
                    //SPEICHERN DER DATEN IN DB
                    $qr='insert into user (`username`,`vorname`,`nachname`,`email`,`is_ldap`) '
                            . 'values ("'.$user.'","'.$VN.'","'.$NN.'","'.$Mail.'","'.$is_ldap.'")';
                    $result=$dbobject->query($qr);

                    if($result===true)
                    {
                        echo '<script>console-log("Insert into DB -> OK");</script>';
                    }
                    else
                    {
                        //echo '<script type="text/javascript">alert("Insert into DB -> FALSE");</script>';
                        echo '<script>console-log("Eintrag in DB fehlgeschlagen");</script>';
                    }
                    
                    session_start();                                    //Session wird gestartet
                    $_SESSION['User']=$user;
                    setcookie("Vorname",$VN,$cookieExpire,$cookiePath);
                    setcookie("Nachname",$NN,$cookieExpire,$cookiePath);
                    setcookie("User",$user,$cookieExpire,$cookiePath); //Cookie 1 Stunde gültig
                    setcookie("PHPSESSID",session_id(),$cookieExpire,$cookiePath);
                    ldap_close($ds);
                    //echo '<script type="text/javascript">alert("Login ok");</script>';
                    $site=$_POST['sec'];
                        if($site=="galerie_nologin")
                            echo '<script type="text/javascript">window.location.href = "index.php?section=galerie"</script>';
                        elseif($site!="nosec")
                            echo '<script type="text/javascript">window.location.href = "index.php?section='.$site.'"</script>';
                        else
                            echo '<script type="text/javascript">window.location.href = "index.php"</script>';
                }
                else
                {
                    echo '<script>console-log("LDAP CONNECTION -> FALSE");</script>';
                    echo '<script type="text/javascript">alert("Login failed");</script>';
                    echo '<script type="text/javascript">window.location.href = "index.php"</script>';
                }
            }
        }
        else //NUR MIT LDAP -> KEINE DB VERBINDUNG MÖGLICH
        {
            echo '<script type="text/javascript">alert("DB CONNECTION ERROR -> ONLY LDAP");</script>';
            $ldapserver=$configs->ldapserver;
            $searchbase=$configs->searchbase;

            $user = strtolower($user);
            $ds=ldap_connect($ldapserver);
            if(!$ds){echo "Connect-Error to ldapserver"; exit;}

            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);


            $ldapbind=false;
            if(ldap_start_tls($ds)) // verschlüsselte Verbindung verwenden
                $dn = "ou=People,".$searchbase;  // wo wird gesucht?
            $ldapbind = @ldap_bind($ds,"uid=".$user.",".$dn,$pass);
            if ($ldapbind) {
                echo '<script>console-log("LDAP CONNECTION -> OK");</script>';
                    // LDAP search (Suche am gebundenen Knoten)
                $filter="(uid=$user)";
                $justthese = array("sn", "givenname", "mail"); // nur nach diesen Einträgen suchen
                $sr=ldap_search($ds, $dn, $filter, $justthese); // Suche wird durchgeführt
                $info = ldap_get_entries($ds, $sr);             // gefundene Einträge werden ausgelesen
                //echo $info["count"]." entries returned\n<br>";
                $data = $info[0][0];
                $VN=$info[0][$data][0];
                $data = $info[0][1];
                $NN=$info[0][$data][0];    
                $data = $info[0][2];
                
                session_start();                                    //Session wird gestartet
                $_SESSION['User']=$user;
                setcookie("Vorname",$VN,$cookieExpire,$cookiePath);
                setcookie("Nachname",$NN,$cookieExpire,$cookiePath);
                setcookie("User",$user,$cookieExpire,$cookiePath); //Cookie 1 Stunde gültig
                setcookie("PHPSESSID",session_id(),$cookieExpire,$cookiePath);
                ldap_close($ds);
                //echo '<script type="text/javascript">alert("Login ok");</script>';
                $site=$_POST['sec'];
                    if($site=="galerie_nologin")
                        echo '<script type="text/javascript">window.location.href = "index.php?section=galerie"</script>';
                    elseif($site!="nosec")
                        echo '<script type="text/javascript">window.location.href = "index.php?section='.$site.'"</script>';
                    else
                        echo '<script type="text/javascript">window.location.href = "index.php"</script>';
            }
            else
            {
                echo '<script type="text/javascript">alert("Login failed");</script>';
                echo '<script type="text/javascript">window.location.href = "index.php"</script>';
            }
        }               
    }
    if(isset($_GET['logout']))   //Wenn Logout gedrückt und Session vorhanden 
    {                                                       //-> SESSION Löschen
        session_unset();
        session_destroy();
        //echo '<script type="text/javascript">alert("Loginout");</script>';
        
        setcookie("User", "anonym", time()+100000000,$cookiePath);
        unset($_COOKIE['User']);
        setcookie("PHPSESSID", "", time()-3600,$cookiePath);
        unset($_COOKIE['PHPSESSID']);
        setcookie("Menu", "", time()-3600,$cookiePath);
        unset($_COOKIE['Menu']);
        setcookie("Vorname", "", time()-3600,$cookiePath);
        unset($_COOKIE['Vorname']);
        setcookie("Nachname", "", time()-3600,$cookiePath);
        unset($_COOKIE['Nachname']);
        
        echo '<script type="text/javascript">window.location.href = "index.php"</script>';
    }
    
?>





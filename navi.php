<?php
/* 
 *Autoren: 	David Dittmann & Johannes Neustädter
 *Datum:	12.03.2018
 *Version:	1.0
 */
 
	if(!isset($_COOKIE["Menu"]))	//Cookie nicht gesetzt -> erster aufruf/invalid
	{								//-->HOME markieren
		setcookie("Menu","home",$cookieExpire,$cookiePath);
	}
	
	if(isset($_GET["section"]))
	{		//Anderer Reiter ausgewählt --> Cookie und Farbe ändern
		$menu = $_GET["section"];
		echo "<style>#".$menu."_nav{background-color:#ADFF2F;}</style>";
		setcookie("Menu",$menu,$cookieExpire,$cookiePath);
	}
	elseif(isset($_COOKIE["Menu"]))
	{
		echo "<style>#".$_COOKIE["Menu"]."_nav{background-color:#ADFF2F;}</style>";
	}
	else
	{
		setcookie("Menu","home",$cookieExpire,$cookiePath);
		echo "<style>#home_nav{background-color:#ADFF2F;}</style>";
	}
?>

<ul>
  <li><a id="home_nav" href="?section=home">Home</a></li>
  <li><a id="produkte_nav" href="?section=produkte">Produkte</a></li>
  <?php
  if(isset($_COOKIE["User"]))
  {
	  echo '
	  <li><a id="galerie_nav" href="?section=galerie">Galerie</a></li>
	  <li><a id="warenkorb_nav" href="?section=warenkorb">Warenkorb</a></li>
	  ';
  }
  else //zeigt wahlweise die galerie mit angemeldeten Benutzer und ohne
  {
	  echo  '<li><a id="galerie_nologin_nav" href="?section=galerie_nologin">Galerie</a></li>';
  }
  ?>
</ul>

<?php
if(isset($_GET["section"]))
{
    $_SESSION["menu"]=$_GET["section"];
}
?>

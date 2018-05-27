<?php
/* 
 *Autoren: 	David Dittmann & Johannes Neustädter
 *Datum:	12.03.2018
 *Version:	1.0
 */
 ?>
<script>
	function showRSS(str) {
		if (str.length==0) { 
			document.getElementById("RSS").innerHTML="";
			return;
		}
		xmlhttp=new XMLHttpRequest();
		
		xmlhttp.onreadystatechange=function()
		{
			if (this.readyState==4 && this.status==200)
			{
				document.getElementById("RSS").innerHTML=this.responseText;
			}
		}
		xmlhttp.open("GET","getrss.php?q="+str,true);
		xmlhttp.send();
	}
</script>
<?php
if((!isset($_SESSION["menu"])&&!isset($_COOKIE["Menu"]))||(!isset($_SESSION["menu"])&&isset($_COOKIE["Menu"])&&$_COOKIE["Menu"]=="home")||(isset($_SESSION["menu"])&&$_SESSION["menu"]=="home")||!isset($_COOKIE["User"]))
{
    echo '<h1 class="text-center">Home</h1>';
	
	?>
	<div id="feedy">
		<div id="titlebox">
			<h2>Load your own Newsfeed</h2>
		</div>
		<div id="formbox">
			<form>
				<div id="inputtitle">
					URL:
				</div>
				<div id="inputbox">
					<input type="url" id="urlin">
				</div>
				<div id="buttonbox">
					<input type="button" value="Laden" onclick="showRSS(urlin.value)">
				</div>
			</form>
		</div>
	</div>
	<?php
	if(!isset($_GET["q"]))
	{
		$i=0;
		echo '<div id="RSS">';
		echo '<h2>NEWSFEED - TU WIEN</h2>';
			$myFeed = simplexml_load_file("http://www.tuwien.ac.at/index.php?id=157&type=100");
			
			foreach($myFeed->channel->item as $eintrag){
				$i++;
				if($i%2==0)
				{
					echo '<div class="bluebox">';
				}
				else
				{
					echo '<div class="greybox">';
				}
				echo '<a href="'.$eintrag->link.'">'.$eintrag->title.'</a>';
				echo "<br/>";
				echo $eintrag->description;
				echo "<br/>";
				echo "</div>";
			}
			
		echo '</div>';
	}
	else
	{
		$i=0;
		echo '<div id="RSS">';
		echo '</div>';
	}
	
	
	//-----------------VITAL ZEUGS---------------------
	
	
	$data = file_get_contents('http://localhost:8080/rest/items/vital_data/history');
	$obj=json_decode($data);
	echo '<div id="VitalData">';
		echo "<h2>Vitalparameter</h2>";
		echo "<table>";
		echo "<tr><th>ID</th><th>Name</th><th>Uhrzeit</th><th>Blutdruck Diastolisch</th><th>Blutdruck Systolisch</th><th>Puls</th></tr>";
		foreach($obj as $entry)
		{
			echo "<tr><td>".$entry->id."</td>";
			echo "<td>".$entry->name."</td>";
			echo "<td>".$entry->timestamp."</td>";
			echo "<td>".$entry->diastolic_pressure." ".$entry->pressure_unit."</td>";
			echo "<td>".$entry->systolic_pressure." ".$entry->pressure_unit."</td>";
			echo "<td>".$entry->heart_rate." ".$entry->heart_rate_unit."</td></tr>";
		}
		echo "</table>";
	echo "</div>";
	
}

elseif((isset($_SESSION["menu"])&&$_SESSION["menu"]=="produkte")||(isset($_COOKIE["Menu"])&&$_COOKIE["Menu"]=="produkte"&&(!isset($_SESSION["menu"]))))
{
	echo '<h1 class="text-center">Rechner</h1>';
	
		//-----------------Rechner---------------------
		?>
		<div class="<?php echo $configs->class_rechner_off;?>"></div>
		<div id="rechner" class="<?php echo $configs->class_rechner_off;?> text-center">
			
		
			<form method="post">
				<p>1 Zahl: <input name="z1" type="number"></p>
				<p>2 Zahl: <input name="z2" type="number"></p>
		
				<input class="rech_button" type="submit" name="add" value="Add">
				<input class="rech_button" type="submit" name="subtract" value="Subtract">
				<input class="rech_button" type="submit" name="multiply" value="Multiply">
				<input class="rech_button" type="submit" name="divide" value="Divide">
			</form>
	
		<div id="rech_erg">
		<h2>Ergebnis:</h2>
		
		<?php
		//if (isset($_POST["add"]) || isset($_POST["subtract"]) || isset($_POST["multiply"]) || isset($_POST["divide"]))
			
		//WSDL-Adresse
		$calculateServiceWSDL = "http://www.dneonline.com/calculator.asmx?wsdl";
		//Initialisierung SOAP-Client
		$calculateServiceClient = new SoapClient($calculateServiceWSDL);
	
		$params = array();
	
	
		if (isset($_POST["add"]))
		{
			$params["intA"] = $_POST["z1"];
			$params["intB"] = $_POST["z2"];
			echo $calculateServiceClient->Add($params)->AddResult;
		} 
		else if (isset($_POST["subtract"]))
		{
			$params["intA"] = $_POST["z1"];
			$params["intB"] = $_POST["z2"];
			echo $calculateServiceClient->Subtract($params)->SubtractResult;
		} 
		else if (isset($_POST["multiply"]))
		{
			$params["intA"] = $_POST["z1"];
			$params["intB"] = $_POST["z2"];
			echo $calculateServiceClient->Multiply($params)->MultiplyResult;
		} 
		else if (isset($_POST["divide"]))
		{
			$params["intA"] = $_POST["z1"];
			$params["intB"] = $_POST["z2"];
			echo $calculateServiceClient->Divide($params)->DivideResult;
		}

		?>
		</div>
		</div>
		<?php
		
}
elseif((isset($_SESSION["menu"])&&$_SESSION["menu"]=="galerie")||(isset($_COOKIE["Menu"])&&$_COOKIE["Menu"]=="galerie"&&(!isset($_SESSION["menu"])))&&isset($_COOKIE["User"]))
{
	include("gallery.php"); 

	include("upload.php");
}
elseif((isset($_SESSION["menu"])&&$_SESSION["menu"]=="galerie_nologin")||(isset($_COOKIE["Menu"])&&$_COOKIE["Menu"]=="galerie_nologin"&&(!isset($_SESSION["menu"]))))
{
	include("gallery.php");
	
	echo '
	<h1 class="text-center">Upload</h1>
	<div id="gallery_nologin" class="'.$configs->class_gallery_noupload.'">
	<h2 class="text-center">Nur angemeldete User können Bilder hinzufügen und bearbeiten.</h2>
	</div>
	';
}
elseif((isset($_SESSION["menu"])&&$_SESSION["menu"]=="warenkorb")||(isset($_COOKIE["Menu"])&&$_COOKIE["Menu"]=="warenkorb"&&(!isset($_SESSION["menu"]))))
{
    echo '<h1 class="text-center">Warenkorb</h1>
	Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.   
	<br>
	<img src="res/img/premium_user.png" align="middle"></img>
	';
}
?>




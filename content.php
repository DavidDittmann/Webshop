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
    echo '<h1 class="text-center">Home</h1>
	<div class="container">
	Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
	Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.   
	<br>
	Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.   
	<br>
	</div>
	';
	
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
			echo "<td>".$entry->name."<td>";
			echo "<td>".$entry->timestamp."<td>";
			echo "<td>".$entry->diastolic_pressure." ".$entry->pressure_unit."</td>";
			echo "<td>".$entry->systolic_pressure." ".$entry->pressure_unit."</td>";
			echo "<td>".$entry->heart_rate." ".$entry->heart_rate_unit."</td></tr>";
		}
		echo "</table>";
	echo "</div>";
	
	
	//print_r($obj);
	

	/*print $obj->{"id"}." ";
	print $obj->{"name"}." ";
	print $obj->{"timestamp"}." ";
	print $obj->{"diastolic_pressure"}." ";
	print $obj->{"systolic_pressure"}." ";
	print $obj->{"heart_rate"}." ";
	print $obj->{"pressure_unit"}." ";
	print $obj->{"heart_rate_unit"}." ";*/
	echo "<br>";
	
}
elseif((isset($_SESSION["menu"])&&$_SESSION["menu"]=="produkte")||(isset($_COOKIE["Menu"])&&$_COOKIE["Menu"]=="produkte"&&(!isset($_SESSION["menu"]))))
{
    echo '<h1 class="text-center">Produkte</h1>
	<div class="container">
	
	Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.   
	<br>
	Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.   
	<br>
	At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, At accusam aliquyam diam diam dolore dolores duo eirmod eos erat, et nonumy sed tempor et et invidunt justo labore Stet clita ea et gubergren, kasd magna no rebum. sanctus sea sed takimata ut vero voluptua. est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat.   
	<br>
	Consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus.   
	<br>
	Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi.   
	<br>
	Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
	</div>
	';
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




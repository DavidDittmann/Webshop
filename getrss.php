<?php
//get the q parameter from URL
$q=$_GET["q"];

$myFeed = simplexml_load_file($q);
$i=0;

echo '<h2>NEWSFEED - '.$q.'</h2>';
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
		echo '</div>';

}
?>
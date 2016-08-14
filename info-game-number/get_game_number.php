<?php 
$max = 126;
$zoom = file_get_contents("../sessions/zoom_gamenumber");
$current = count(scandir('../sessions/matchcards/'))-2;
if($current > $max ) { $current = $max; }
?>	
<div style="font-size: <?php echo $zoom; ?>">aktuelles Spiel
<br>#<?php echo $current; ?> von <?php echo $max; ?> <br><br>
<table style="height: 200px; width: <?php echo ($current/$max)*100; ?>%"><td style="width:<?php echo ($current/$max)*100; ?>%; background: lime; text-align: right">&nbsp;</td></table>
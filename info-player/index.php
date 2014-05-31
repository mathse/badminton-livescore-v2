<?php
$players = array("HE","DE","HD","DD","MX");
foreach($players as $player) {
	$arr = file('../players/'.$player.'.txt');
	echo "<h1>".$player."</h1><br><table>";	
	foreach($arr as $line) {
		if($player == 'HE' || $player == 'DE') {
			echo '<tr><td>'.substr($line,0,3).'</td><td>'.substr($line,4).'</td><td>&nbsp;</td></tr>';	
		} else {
			$p = explode(" / ",substr($line,8));
			
			echo '<tr><td>'.substr($line,0,3).'</td><td>'.$p[0].'</td><td>'.$p[1].'</td><td>&nbsp;</td></tr>';	
		}
	}
	echo '</table>';
}
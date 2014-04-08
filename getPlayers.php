<?php
header("Content-type: text/xml");
include('settings.php');
//echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>';
if(!$_GET['event']) { echo "event is missing"; exit; }
if(!$_GET['nation'])
{
	$players = file('players/'.$_GET['event'].'.txt');
	foreach($players as $player)
	{
			$line = explode(' ',$player);
			$nations[] = $line[0];
	}
	sort($nations);
	$nations = array_unique($nations);
	echo '<option>-select nation-</option>';
	foreach($nations as $nation)
	{
		echo "<option value='".$nation."'>";
		if($_GET['event']=='ms' || $_GET['event']=='ws')
		{
			echo $nation;
		} else {
			$p = explode('|',$nation);
			if($p[0] == $p[1]) {
				echo $p[0];
			} else {
				echo $nation;					
			}
		}		
		echo "</option>";	
	}
	
} else {
	$players = file('players/'.$_GET['event'].'.txt');
	$i=-1;
	foreach($players as $player)
	{
			$i++;
			$player = str_replace("\n",'',$player);
			//$player = str_replace(',','',$player);
			$line = explode(' ',$player);
			$nation = $line[0];
			if($nation != $_GET['nation']) continue;

			if(strtolower($_GET['event'])=='ms' || strtolower($_GET['event'])=='de' || strtolower($_GET['event'])=='he' || strtolower($_GET['event'])=='ws' || $_GET['event']=='zz' )
			{
				$players_list[$i] = substr($player,4);
			//	$players_list[$i] = $line[2].' '.$line[1];
			} else {
				$players_list[$i] = substr($player,8);
		//		$players_list[$i] = $line[2].' '.$line[1].' &amp; '.$line[4].' '.$line[3];
			} 
	}
	
	$players_list = array_unique($players_list);
	echo '<option>-select player-</option>';
		
	foreach($players_list as $key => $player)
	{
		$player = ucwords(str_replace('&nbsp;',' ',strtolower($player)));
		echo "<option value='".$_GET['event'].'-'.$key."'>".substr($player,0,100)."</option>";	
	
	}	
	
}

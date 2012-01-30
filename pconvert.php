<?php
//$file =file_get_contents('http://www.tournamentsoftware.com/sport/event.aspx?id=74DABAD8-6B0B-4395-A8CA-A47DAFF89B4F&event=2');
$x = explode("<td>Player</td><td>Seed</td>",$file); //for singles
$lines = str_replace("\r\n\r\n","\n",str_replace("	","",strip_tags($x[1])));
//echo $lines;
$regex = "/\[(\w+)\] ([\'\w&#;\- ]+), ([\'a-zA-Z0-9,&#;\- ]+)/";
preg_match_all ($regex, $lines, $output); 
for($i=0;$i<count($output[1]);$i++) {
	echo $output[1][$i].' '.ucwords(strtolower($output[3][$i])).' '.ucwords(strtolower($output[2][$i]));	
	echo "\n";
}




$file =file_get_contents('http://www.tournamentsoftware.com/sport/event.aspx?id=74DABAD8-6B0B-4395-A8CA-A47DAFF89B4F&event=3');
$x = explode("<td>Player</td><td>Partner</td><td>Seed</td>",$file); //for mix and doubles
$lines = str_replace("\r\n\r\n","\n",str_replace("	","",strip_tags($x[1])));
//echo $lines;
$regex = "/\[(\w+)\] ([\'\w,&#;\- ]+), ([\'\w,&#;\- ]+)\[(\w+)\] ([\'\w,&#;\- ]+), ([\'a-zA-Z0-9,&#;\- ]+)/";
preg_match_all ($regex, $lines, $output); 
for($i=0;$i<count($output[1]);$i++) {
	echo $output[1][$i].'|'.$output[4][$i].' '.ucwords(strtolower($output[3][$i])).' '.ucwords(strtolower($output[2][$i])).' &amp; '.ucwords(strtolower($output[6][$i])).' '.ucwords(strtolower($output[5][$i]));	
	echo "\n";
}
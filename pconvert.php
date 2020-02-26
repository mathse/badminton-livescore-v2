<?php
include('settings.php');

$types = array("ms", "ws", "md", "wd", "xd");
$counter =0;
foreach($types as $key => $type) {
	$buffer = null;
    $counter++;
    $url = 'https://www.tournamentsoftware.com/sport/event.aspx?id='.$tID.'&event='.($key+1).'&draw='.$counter;

	echo "... importing ".$type." from ".$url."<br>";
	$file = file_get_contents($url);
    // echo $file;
    // break;
	if($key>1) {
		$x = explode("<td>Player</td><td>Partner</td><td>Seed</td>",$file); //for mix and doubles
		$regex = "/\[(\w+)\] ([\'\w,&#;\- ]+), ([\'\w,&#;\- ]+)\[(\w+)\] ([\'\w,&#;\- ]+), ([\'a-zA-Z0-9,&#;\- ]+[a-z])([0-9\/]*)/";
	} else {
		$x = explode("<td>Player</td><td>Seed</td>",$file); //for singles
		$regex = "/\[(\w+)\] ([\'\w&#;\- ]+), ([\'a-zA-Z0-9,&#;\- ]+[a-z])([0-9\/]*)/";
	}
	$lines = str_replace("\r\n\r\n","\n",str_replace("	","",strip_tags($x[1])));
	preg_match_all ($regex, $lines, $output);
	#print_r($output);
	for($i=0;$i<count($output[1]);$i++) {
		if($key>1) {
			$flags[] = $output[1][$i];
			$flags[] = $output[4][$i];
			$buffer .= $output[1][$i].'|'.$output[4][$i].' '.ucwords(strtolower($output[3][$i])).' '.ucwords(strtolower($output[2][$i])).' &amp; '.ucwords(strtolower($output[6][$i])).' '.ucwords(strtolower($output[5][$i]));
		} else {
			$flags[] = $output[1][$i];
			$buffer .= $output[1][$i].' '.ucwords(strtolower($output[3][$i])).' '.ucwords(strtolower($output[2][$i]));
		}
		$buffer .= "\n";
	}
	// $fd = fopen('./players/'.$type.'.txt','wa+');
	echo html_entity_decode($buffer).'<br>';
	// $enc = mb_detect_encoding($data);
    // //
	// $buffer = mb_convert_encoding($buffer, "UTF-8", $enc);
	// fwrite($fd,html_entity_decode($buffer));
	// fclose($fd);

    file_put_contents('./players/'.$type.'.txt', $buffer);
    // file_put_contents('tempfolder/'.$a, $data);


}

echo "checking for missing flags ...<br>";
$flags = array_unique($flags);
foreach($flags as $flag) {
//	echo '<img src="./img/flags/'.$flag.'.png" title="'.$flag.'">';
	if(!file_exists('./img/flags/'.$flag.'.png')) echo $flag.' missing <a href="http://www.google.de/search?um=1&hl=de&client=ubuntu&hs=iaC&channel=cs&biw=1920&bih=994&tbm=isch&q=flag:+'.$flag.'+wikipedia&spell=1&sa=X&ei=hXEzUYqbFcXysgbq-oCQAg&ved=0CE0QBSgA">&gt;&gt;</a> <br>';
}


/*
$file =file_get_contents('http://www.tournamentsoftware.com/sport/event.aspx?id=74DABAD8-6B0B-4395-A8CA-A47DAFF89B4F&event=3');
$x = explode("<td>Player</td><td>Partner</td><td>Seed</td>",$file); //for mix and doubles
$lines = str_replace("\r\n\r\n","\n",str_replace("	","",strip_tags($x[1])));
//echo $lines;
$regex = "/\[(\w+)\] ([\'\w,&#;\- ]+), ([\'\w,&#;\- ]+)\[(\w+)\] ([\'\w,&#;\- ]+), ([\'a-zA-Z0-9,&#;\- ]+)/";
preg_match_all ($regex, $lines, $output);
for($i=0;$i<count($output[1]);$i++) {
	echo $output[1][$i].'|'.$output[4][$i].' '.ucwords(strtolower($output[3][$i])).' '.ucwords(strtolower($output[2][$i])).' &amp; '.ucwords(strtolower($output[6][$i])).' '.ucwords(strtolower($output[5][$i]));
	echo "\n";
}*/

<meta http-equiv="refresh" content="180; URL=matches.php">

<?php
$day = date("Ymd",time());
if($day == "20140305") { $day = "20140306"; }

function file_get_cached_contents($url) {
	$cache_file = "cache/".md5($url);
	if (file_exists($cache_file) && (filemtime($cache_file) > (time() - 60 * 5 ))) {
	   $file = file_get_contents($cache_file);
	} else {
	   $file = file_get_contents($url);
	   file_put_contents($cache_file, $file, LOCK_EX);
	}
	return $file;
}

$f = file_get_cached_contents("http://www.tournamentsoftware.com/sport/matches.aspx?id=329A5E09-5B17-4B3D-A43A-191D3B42DB35&d=".$day);
$f = str_replace("/VisualResource.ashx","./VisualResource_m.css",$f);
$f = str_replace("Tournament days","",$f);
//echo $f;

$xmlDoc = new DOMDocument();
$xmlDoc->loadHTML($f);
$xmlDoc->preserveWhiteSpace = false; 
//print_r($xmlDoc);

$now = date("H",time());

for($i=10;$i<$now;$i++) {
	#echo $i;	
	$f = preg_replace('/<tr>[\n\r\t ]+<td><\/td><td align="right">'.$i.'/','<tr style="display: none"><td></td><td align="right">+++',$f);
}
if($now > 12) {
	$now = date("g",time());
	for($i=0;$i<$now;$i++) {
		#echo $i;	
		$f = preg_replace('/<tr>[\n\r\t ]+<td><\/td><td align="right">'.$i.'/','<tr style="display: none"><td></td><td align="right">+++',$f);
	}
}
echo $f;
?>

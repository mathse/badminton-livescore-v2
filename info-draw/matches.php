<?php
include('../settings.php');
$day = date("Ymd",time());
if($day == "20150513") { $day = "20150515"; }

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

$f = file_get_cached_contents("http://www.turnier.de/sport/matches.aspx?id=".$tID."&d=".$day);
$f = str_replace("/VisualResource.ashx","./VisualResource_m.css",$f);
$f = str_replace("Tournament days","",$f);
//echo $f;

$xmlDoc = new DOMDocument();
$xmlDoc->loadHTML($f);
$xmlDoc->preserveWhiteSpace = false; 
//print_r($xmlDoc);

$now = date("H",time())-1;

#for($i=9;$i<$now;$i++) {
#	echo $i;	
#	$f = preg_replace('/<tr>[\n\r\t ]+<td><\/td><td class="[a-z]+" align="right">[0-9]*'.$i.'/','<tr style="display: none"><td></td><td align="right">+++',$f);
#}
#$f = preg_replace('/<tr>[\n\r\t ]+<td><\/td><td class="[a-z]+" align="right">[0-9]+:[0-9 APM]+<\/td><td><a href="[a-zA-Z0-9\.\/?=\-&]+">.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+<a href=".+">Sport[0-9a-z\- ]+<\/a><\/td>/','<tr style="display: none">',$f);
$f = preg_replace('/<tr[^>]*>.*?[\d]+-[\d]+<\/span><\/span>/s','<tr style="display: none">',$f);
$f = preg_replace('/<tr>[\n\r\t ]+<td><\/td><td class="[a-z]+" align="right">[0-9]+:[0-9]+<\/td><td><a href="[a-zA-Z0-9\.\/?=\-&]+">.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+Walkover<\/span><\/td>/','<tr style="display: none">',$f);


// <tr>[\n\r\t ]+<td><\/td><td class="[a-z]+" align="right">[0-9]+:[0-9]+<\/td><td><a href="[a-zA-Z0-9\.\/?=\-&]+">.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+\n.+<a href=".+">Sportforum - Feld [0-9]+<\/a><\/td>
if($now > 25) {
	$now = date("g",time());
	for($i=0;$i<$now;$i++) {
		#echo $i;	
		$f = preg_replace('/<tr>[\n\r\t ]+<td><\/td><td class="[a-z]+" align="right">'.$i.'/','<tr style="display: none"><td></td><td align="right">+++',$f);
	}
}
if(@$_GET['type'] == 'xml') {
    $re = '/draw=[\d]+">([A-Z0-9 ]+).+\n.+\n.+player=[\d]+">([\w\- ]+).+\n.+\n.+\n.+\n.+player=[\d]+">([\w\- ]+)/u';
    preg_match_all($re, $f, $matches);
    header("Content-type: text/xml; charset=utf-8");

    for($i=0;$i<count($matches[1]);$i++) {
        echo '<option>'.$matches[1][$i].' '.$matches[2][$i].' vs '.$matches[3][$i].'</option>';
    }

} else {
    ?><meta http-equiv="refresh" content="180; URL=matches.php"><?php
    echo $f;
}
?>

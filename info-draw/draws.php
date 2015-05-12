<?php
include('../settings.php');

if(!$_GET['draw']) { $_GET['draw']=1; }
$next = $_GET['draw']+1;

// forward


if($next == 5) { $next = 1; }
if($next == 6) { $next = 1; }
if($next == 11) { $next = 15; }
if($next == 16) { $next = 20; }
if($next == 21) { $next = 25; }
if($next == 26) { $next = 30; }
if($next == 31) { $next = 35; }
if($next == 36) { $next = 40; }




// reset to start

if($next == 44) { $next = 5; }

function file_get_cached_contents($url) {
	$cache_file = "cache/".md5($url);
	if (file_exists($cache_file) && (filemtime($cache_file) > (time() - 60 * 7 ))) {
	   $file = file_get_contents($cache_file);
	} else {
	   $file = file_get_contents($url);
	   file_put_contents($cache_file, $file, LOCK_EX);
	}
	return $file;
}

$f = file_get_cached_contents("http://www.tournamentsoftware.com/sport/draw.aspx?id=".$tID."&draw=".$_GET['draw']);
$f = str_replace("/VisualResource.ashx","./VisualResource.css",$f);
$f = str_replace("All matches...","",$f);
$re = '/<title>[ \r\n\t\w\d\.\ ]+ - ([\w\d\.\ ]+) - [ \r\n\t\w\d\.\ ]+<\/title>/';
preg_match($re, $f, $matches);
//print_r($matches);
?><div id="myheader" style="position: absolute; top: 0px; left: 0px; background: rgba(0,0,0,0.7);; width: 100%; ">
<h1 style="padding: 10px; font-size: 2em"><?php echo $matches[1]; ?> - <?php echo date("l d.m.Y",time()); ?> - <?php
$caption = explode("caption>",$f);
echo $caption[1];

?></h1><div id="infoheader" style="opacity: 0.4"></div>
</div><?php
echo $f
?><script type="text/javascript">

var speed=2

var currentpos=0,alt=1,curpos1=-1,curpos2=-1

function initialize(){
	starttime = new Date().getTime();
	startit()
	
}
old = 0
function scrollwindow(){
	if (document.all && !document.getElementById)
		temp=document.body.scrollTop
	else
		temp=window.pageYOffset
	
	if (alt==0)
		alt=2
	else
		alt=1
	
	if (alt==0)
		curpos1=temp
	else
		curpos2=temp
	
	if (curpos1!=curpos2){
		if (document.all) {
			currentpos = document.body.scrollTop + speed
		} else {
			currentpos = window.pageYOffset + speed
		}
		//alert(currentpos)
		if (old==currentpos && speed != 0 && runtime > 10000) {
			speed=0
			//alert("ende"+temp)
			window.location.href = "draws.php?draw=<?php echo $next; ?>"
		} else {
			old = currentpos
		}
		window.scroll(0,currentpos)
		document.getElementById("myheader").style.top = window.pageYOffset;
		nowtime = new Date().getTime();
		runtime = nowtime - starttime;
		//document.getElementById("infoheader").innerHTML = ;
	}else{
		currentpos=0
		window.scroll(0,currentpos)
		//document.getElementById("header").style.top = window.pageYOffset;
	}
}

function startit(){
	setInterval("scrollwindow()",50)
}

window.onload=initialize

bottom();
</script>
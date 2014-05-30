<?php
$tID = '74EFFA13-D03E-4F75-8C55-9A4227C63312';
if(!$_GET['draw']) { $_GET['draw']=1; }
$next = $_GET['draw']+1;

// forward

if($next == 3) { $next = 6; }
if($next == 8) { $next = 11; }
if($next == 13) { $next = 16; }
if($next == 18) { $next = 21; }
if($next == 23) { $next = 26; }
if($next == 28) { $next = 31; }
if($next == 33) { $next = 36; }
if($next == 38) { $next = 41; }


// reset to start

#if($next == 6) { $next = ''; }

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
?><div id="myheader" style="position: absolute; top: 0px; left: 0px; background: rgba(0,0,0,0.7);; width: 100%; ">
<h1 style="padding: 10px; font-size: 2em">27. Deutsche Meisterschaften - Freitag <?php echo date("d.m.Y",time()); ?> - <?php
$caption = explode("caption>",$f);
echo $caption[1];

?></h1>
</div><?php
echo $f
?><script type="text/javascript">

var speed=2

var currentpos=0,alt=1,curpos1=-1,curpos2=-1

function initialize(){
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
		if (old==currentpos && speed != 0 ) {
			speed=0
			//alert("ende"+temp)
			window.location.href = "draws.php?draw=<?php echo $next; ?>"
		} else {
			old = currentpos
		}
		window.scroll(0,currentpos)
		document.getElementById("myheader").style.top = window.pageYOffset;
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
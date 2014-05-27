<?php
if(!$_GET['draw']) { $_GET['draw']=1; }
$next = $_GET['draw']+1;
if($next == 6) { $next =''; }

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

$f = file_get_cached_contents("http://www.tournamentsoftware.com/sport/draw.aspx?id=329A5E09-5B17-4B3D-A43A-191D3B42DB35&draw=".$_GET['draw']);
$f = str_replace("/VisualResource.ashx","./VisualResource.css",$f);
$f = str_replace("All matches...","",$f);
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
	}else{
		currentpos=0
		window.scroll(0,currentpos)
	}
}

function startit(){
	setInterval("scrollwindow()",50)
}

window.onload=initialize

bottom();
</script>
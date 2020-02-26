<html>
<meta http-equiv="refresh" content="5; URL=check.php?c=<?php echo $_GET['c']; ?>">
<?php
$time = (time() - @filemtime('sessions/courts/'.$_GET['c']));
if($time < 45) {
	$color = "black";
} else {
	$color = "red";
}

$f = json_decode(@file_get_contents('sessions/courts/'.$_GET['c']));
// print_r($f);
if(@$f->service==0) {
	$color = "black";
}


?>

<body style="overflow:hidden; background: <?php echo $color; ?>; color: white">
<span style="font-size: 1em">
<?php
echo $_GET['c'];
?>
</span>
</body>
</html>

<html>
<?php
error_reporting(-1);
ini_set('display_errors', 'Off');
$h=0; $g=0;

/*
$a = array(
 array("","","","","",""),
 array("","","","","",""),
 array("","","","","",""),
 array("","","","","",""),
 array("","","","","",""),
 array("","","","","",""),
 array("","","","","",""),
 array("","","","","",""),
 "TV Emsdetten", //gegner
);
*/
include('./players/overview.php');
/*$a = array(
array("","","","","",""),
array("","","","","",""),
array("","","","","",""),
array("","","","","",""),
array("","","","","",""),
array("","","","","",""),
array("","","","","",""),
array("","","","","",""),
"BW Wittorf", //gegner
);*/
?>

<meta http-equiv="refresh" content="5; url=overview.php">
<style type="text/css">
* { color: white; background: black; font-family: Verdana; font-size: 1.11em; font-weight: bold }
</style>
<body><br>
<center>
<table>
<tr>
    <td colspan="2" align="right" style="font-size:2em">SG EBT Berlin</td>
    <td>-</td>
    <td colspan="4" style="font-size:2em" nowrap><?php echo $a[count($a)-1]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">1. HD</td>
    <td style="background: <?php if($a[0][1] == 'h') { echo 'lime'; } ?>"><?php echo $a[0][2]; ?></td>
    <td/>
    <td style="background: <?php if($a[0][1] == 'g') { echo 'lime'; } ?>"><?php echo $a[0][3]; ?></td>
    <td><?php echo $a[0][0]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">DD</td>
    <td style="background: <?php if($a[1][1] == 'h') { echo 'lime'; } ?>"><?php echo $a[1][2]; ?></td>
    <td />
    <td style="background: <?php if($a[1][1] == 'g') { echo 'lime'; } ?>"><?php echo $a[1][3]; ?></td>
    <td><?php echo $a[1][0]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">2. HD</td>
    <td style="background: <?php if($a[2][1] == 'h') { echo 'lime'; } ?>"><?php echo $a[2][2]; ?></td>
    <td />
    <td style="background: <?php if($a[2][1] == 'g') { echo 'lime'; } ?>"><?php echo $a[2][3]; ?> </td>
    <td><?php echo $a[2][0]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">DE</td>
    <td style="background: <?php if($a[3][1] == 'h') { echo 'lime'; } ?>"><?php echo $a[3][2]; ?> </td>
    <td />
    <td style="background: <?php if($a[3][1] == 'g') { echo 'lime'; } ?>"><?php echo $a[3][3]; ?> </td>
    <td><?php echo $a[3][0]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">Mixed</td>
    <td style="background: <?php if($a[4][1] == 'h') { echo 'lime'; } ?>"><?php echo $a[4][2]; ?> </td>
    <td />
    <td style="background: <?php if($a[4][1] == 'g') { echo 'lime'; } ?>"><?php echo $a[4][3]; ?> </td>
    <td><?php echo $a[4][0]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">1. HE</td>
    <td style="background: <?php if($a[5][1] == 'h') { echo 'lime'; } ?>"><?php echo $a[5][2]; ?> </td>
    <td />
    <td style="background: <?php if($a[5][1] == 'g') { echo 'lime'; } ?>"><?php echo $a[5][3]; ?></td>
    <td><?php echo $a[5][0]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">2. HE</td>
    <td style="background: <?php if($a[6][1] == 'h') { echo 'lime'; } ?>"><?php echo $a[6][2]; ?> </td>
    <td />
    <td style="background: <?php if($a[6][1] == 'g') { echo 'lime'; } ?>"><?php echo $a[6][3]; ?> </td>
    <td><?php echo $a[6][0]; ?></td>
</tr>
<tr><td/><td style="font-size:4em" align="right">
<?
for($i=0;$i<7;$i++) {
	if($a[$i][1] == "h") {
		$h++;
	}
}
echo $h;
?>
</td><td>:</td><td style="font-size:4em">
<?
for($i=0;$i<8;$i++) {
	if($a[$i][5] == "g") {
		$g++;
	}
}
echo $g;
?>
</td></tr>
</table>
</center>

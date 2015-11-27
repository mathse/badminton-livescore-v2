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
 array("Heino / Franke","Kuznetsov / Schmitz","21:19","13:21","15:21","g"),
 array("Jonathans / Deichgr&auml;ber","Efler / Wienefeld","18:21","12:21","","g"),
 array("Lehmann / Borsutzki","Koljonen / Pohl","6:21","6:21","","g"),
 array("Lisa Deichgr&auml;ber","Inken Wienefeld","21:8","21:15","","h"),
 array("Aarnio / Jonathans","Kuznetsov / Efler","18:21","22:20","10:21","g"),
 array("Eetu Heino","Kalle Koljonen","21:16","21:12","","h"),
 array("Henri Aarnio","Mathieu Pohl","21:17","21:15","","h"),
 array("Robert Franke","Stefan Lesch","21:14","21:9","","h"),
 "TV Emsdetten", //gegner
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
    <td colspan="4" style="font-size:2em" nowrap><?php echo $a[8]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">1. HD</td>
    <td style="background: <?php if($a[0][5] == 'h') { echo 'lime'; } ?>"><?php echo $a[0][0]; ?></td>
    <td/>
    <td style="background: <?php if($a[0][5] == 'g') { echo 'lime'; } ?>"><?php echo $a[0][1]; ?></td>
    <td><?php echo $a[0][2]; ?></td>
    <td><?php echo $a[0][3]; ?></td>
    <td><?php echo $a[0][4]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">DD</td>
    <td style="background: <?php if($a[1][5] == 'h') { echo 'lime'; } ?>"><?php echo $a[1][0]; ?></td>
    <td />
    <td style="background: <?php if($a[1][5] == 'g') { echo 'lime'; } ?>"><?php echo $a[1][1]; ?></td>
    <td><?php echo $a[1][2]; ?></td>
    <td><?php echo $a[1][3]; ?></td>
    <td><?php echo $a[1][4]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">2. HD</td>
    <td style="background: <?php if($a[2][5] == 'h') { echo 'lime'; } ?>"><?php echo $a[2][0]; ?></td>
    <td />
    <td style="background: <?php if($a[2][5] == 'g') { echo 'lime'; } ?>"><?php echo $a[2][1]; ?> </td>
    <td><?php echo $a[2][2]; ?></td>
    <td><?php echo $a[2][3]; ?></td>
    <td><?php echo $a[2][4]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">DE</td>
    <td style="background: <?php if($a[3][5] == 'h') { echo 'lime'; } ?>"><?php echo $a[3][0]; ?> </td>
    <td />
    <td style="background: <?php if($a[3][5] == 'g') { echo 'lime'; } ?>"><?php echo $a[3][1]; ?> </td>
    <td><?php echo $a[3][2]; ?></td>
    <td><?php echo $a[3][3]; ?></td>
    <td><?php echo $a[3][4]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">Mixed</td>
    <td style="background: <?php if($a[4][5] == 'h') { echo 'lime'; } ?>"><?php echo $a[4][0]; ?> </td>
    <td />
    <td style="background: <?php if($a[4][5] == 'g') { echo 'lime'; } ?>"><?php echo $a[4][1]; ?> </td>
    <td><?php echo $a[4][2]; ?></td>
    <td><?php echo $a[4][3]; ?></td>
    <td><?php echo $a[4][4]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">1. HE</td>
    <td style="background: <?php if($a[5][5] == 'h') { echo 'lime'; } ?>"><?php echo $a[5][0]; ?> </td>
    <td />
    <td style="background: <?php if($a[5][5] == 'g') { echo 'lime'; } ?>"><?php echo $a[5][1]; ?></td>
    <td><?php echo $a[5][2]; ?></td>
    <td><?php echo $a[5][3]; ?></td>
    <td><?php echo $a[5][4]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">2. HE</td>
    <td style="background: <?php if($a[6][5] == 'h') { echo 'lime'; } ?>"><?php echo $a[6][0]; ?> </td>
    <td />
    <td style="background: <?php if($a[6][5] == 'g') { echo 'lime'; } ?>"><?php echo $a[6][1]; ?> </td>
    <td><?php echo $a[6][2]; ?></td>
    <td><?php echo $a[6][3]; ?></td>
    <td><?php echo $a[6][4]; ?></td>
</tr>
<tr>
    <td style="font-size: 0.9em">3. HE</td>
    <td style="background: <?php if($a[7][5] == 'h') { echo 'lime'; } ?>"><?php echo $a[7][0]; ?> </td>
    <td />
    <td style="background: <?php if($a[7][5] == 'g') { echo 'lime'; } ?>"><?php echo $a[7][1]; ?> </td>
    <td><?php echo $a[7][2]; ?></td>
    <td><?php echo $a[7][3]; ?></td>
    <td><?php echo $a[7][4]; ?></td>
</tr>
<tr><td/><td style="font-size:4em" align="right">
<?
for($i=0;$i<8;$i++) {
	if($a[$i][5] == "h") {
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

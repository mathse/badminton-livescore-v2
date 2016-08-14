<?php
header("Content-type: text/xml; charset=utf-8");
include('settings.php');
error_reporting(E_ERROR | E_PARSE);
if(!$_GET['input'])
{
	$fd=@fopen('sessions/'.$deviceid,'w');
	fputs($fd, time());
	fclose($fd);
}

$player1 = '-';
$player2 = '-';
for($set=1;$set<=$maxSets;$set++) {
	$sets[$set]['p1'] = '-';
	$sets[$set]['p2'] = '-';
	$sets[$set]['winner'] = 0;
}
//print_r($sets);
//$set1p1 = '-';
//$set1p2 = '-';
//$set2p1 = '-';
//$set2p2 = '-';
//$set3p1 = '-';
//$set3p2 = '-';
$service = '-';
$currentSet = 1;
//$winnerSet1 = 0;
//$winnerSet2 = 0;
//$winnerSet3 = 0;

if($_GET['debugid']) {
	$monitorconnection = @file_get_contents('sessions/connections/'.$deviceid);
} else {
	$monitorconnection = @file_get_contents('sessions/connections/'.$deviceid);
}
//echo $monitorconnection;
// override for input screen
if($_GET['input']==1 && $_GET['court'])
{
	$monitorconnection = $_GET['court'];
}

if($_GET['direct'])
{
	$monitorconnection = $_GET['debugid'];
}

if($monitorconnection != '' && file_exists('sessions/courts/'.$monitorconnection))
{
	$court = file('sessions/courts/'.$monitorconnection);
//	print_r(json_decode($court[0]));
	$parts_player1 = explode("-",json_decode($court[0])->p1);
	$parts_player2 = explode("-",json_decode($court[0])->p2);
	$plist = file('players/'.$parts_player1[0].'.txt');
	
	
	$seperator = strpos(trim($plist[trim($parts_player1[1])])," ");
	
	$player1 = str_replace("&","&amp;",substr(trim($plist[trim($parts_player1[1])]),$seperator+1));
	$player2 = str_replace("&","&amp;",substr(trim($plist[trim($parts_player2[1])]),$seperator+1));
	$flag1 = substr(trim($plist[trim($parts_player1[1])]),0,$seperator);
	$flag2 = substr(trim($plist[trim($parts_player2[1])]),0,$seperator);

	for($set=1;$set<=$maxSets;$set++) {
		$sets[$set]['p1'] = json_decode($court[0])->$set->p1;
		$sets[$set]['p2'] = json_decode($court[0])->$set->p2;
	}
//	$set1p1 = trim($court[2]);
//	$set1p2 = trim($court[3]);
//	if(trim($court[4])) $set2p1 = trim($court[4]);
//	if(trim($court[5])) $set2p2 = trim($court[5]);
//	if(trim($court[6])) $set3p1 = trim($court[6]);
//	if(trim($court[7])) $set3p2 = trim($court[7]);
	$service = json_decode($court[0])->service;
#	print_r($court);


	// set red marker
	for($set=1;$set<=$maxSets;$set++) {
		for ($i = 0; $i < 9; $i++) {
			if ($sets[$set]['p1'] == ($maxPoints + $i) && $sets[$set]['p2'] < ($maxPoints - 1 + $i)) $sets[$set]['winner'] = 1;
			if ($sets[$set]['p2'] == ($maxPoints + $i) && $sets[$set]['p1'] < ($maxPoints - 1 + $i)) $sets[$set]['winner'] = 2;
		}
	}
//	for($i=0;$i<9;$i++)
//	{
//		if($set2p1==($maxpoints+$i) && $set2p2<($maxpoints-1+$i)) $winnerSet2 = 1;
//		if($set2p2==($maxpoints+$i) && $set2p1<($maxpoints-1+$i)) $winnerSet2 = 2;
//	}
//	for($i=0;$i<9;$i++)
//	{
//		if($set3p1==($maxpoints+$i) && $set3p2<($maxpoints-1+$i)) $winnerSet3 = 1;
//		if($set3p2==($maxpoints+$i) && $set3p1<($maxpoints-1+$i)) $winnerSet3 = 2;
//	}
	for($set=1;$set<=$maxSets;$set++) {
		if ($sets[$set]['p1'] == $maxPointsStop) $sets[$set]['winner'] = 1;
		if ($sets[$set]['p2'] == $maxPointsStop) $sets[$set]['winner'] = 2;
	}
//	if($set2p1==$maxPointsStop) $winnerSet2 = 1;
//	if($set2p2==$maxPointsStop) $winnerSet2 = 2;
//	if($set3p1==$maxPointsStop) $winnerSet3 = 1;
//	if($set3p2==$maxPointsStop) $winnerSet3 = 2;

//	if($set2p1=='-' && $winnerSet1>0) { $set2p1='0'; }
//	if($set2p2=='-' && $winnerSet1>0) { $set2p2='0'; }
//	if($set3p1=='-' && $winnerSet2>0 && $winnerSet1!=$winnerSet2) { $set3p1='0'; }
//	if($set3p2=='-' && $winnerSet2>0 && $winnerSet1!=$winnerSet2) { $set3p2='0'; }

	// set green marker on service
	if($set1p1>0 || $set1p2>0) $currentSet = 1;
	if($set2p1>0 || $set2p2>0) $currentSet = 2;
	if($set3p1>0 || $set3p2>0) $currentSet = 3;
	
	$f1 = explode('|',$flag1);
	$f2 = explode('|',$flag2);
	
	if($f1[0]==$f1[1]) {
		$flag1 = $f1[0];
	}
	if($f2[0]==$f2[1]) {
		$flag2 = $f2[0];
	}
	
#	if($flag1=='O35' || $flag1=='O40' || $flag1=='O45' || $flag1=='O50' || $flag1=='O55' || $flag1=='O60' || $flag1=='O65' || $flag1=='O70' || $flag1=='O75' || $flag1=='U15' || $flag1=='U19') $flag1 = 'AAA'; $flag2 = 'AAA';
}
?>
<r>
	<a><?php echo $monitorconnection; ?></a>
	<fontsize><?php echo file_get_contents("sessions/zoom_courts"); ?>%</fontsize>
	<names>
<?php if($flag1!='AAA') { ?>
	<player1><?php echo $player1; ?></player1>
		<player2><?php echo $player2; ?></player2>
<?php } else { ?>
		<player1><?php echo $player1; ?></player1>
		<player2><?php echo $player2; ?></player2>
<?php } ?>
		<flag1><?php echo $flag1; ?></flag1>
		<flag2><?php echo $flag2; ?></flag2>
	</names>
	<sets>
		<?php	for($set=1;$set<=$maxSets;$set++) {	?>
		<set<?= $set; ?>p1><?= $sets[$set]['p1']; ?></set<?= $set; ?>p1>
		<set<?= $set; ?>p2><?= $sets[$set]['p2']; ?></set<?= $set; ?>p2>
		<?php } ?>
	</sets>
	<currentSet><?php echo $currentSet; ?></currentSet>
	<service><?php echo $service; ?></service>
	<?php	for($set=1;$set<=$maxSets;$set++) {	?>
	<winnerSet<?= $set; ?>><?= $sets[$set]['winner'] ?></winnerSet<?= $set; ?>>
	<?php } ?>
</r>

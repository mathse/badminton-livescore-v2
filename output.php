<?php
header("Content-type: text/xml");
include('settings.php');

if(!$_GET['input'])
{
	$fd=fopen('sessions/'.$deviceid,'w');
	fputs($fd, time());
	fclose($fd);
}

$player1 = '-';
$player2 = '-';
$set1p1 = '-';
$set1p2 = '-';
$set2p1 = '-';
$set2p2 = '-';
$set3p1 = '-';
$set3p2 = '-';
$service = '-';
$currentSet = 1;
$winnerSet1 = 0;
$winnerSet2 = 0;
$winnerSet3 = 0;

$monitorconnection = @file_get_contents('sessions/connections/'.$deviceid);

// override for input screen
if($_GET['input']==1 && $_GET['court'])
{
	$monitorconnection = $_GET['court'];
}

if($monitorconnection != '' && file_exists('sessions/courts/'.$monitorconnection))
{
	$court = file('sessions/courts/'.$monitorconnection);
	 
	$parts_player1 = explode("-",$court[0]);
	$parts_player2 = explode("-",$court[1]);
	$plist = file('players/'.$parts_player1[0].'.txt');
	
	
	$seperator = strpos(trim($plist[trim($parts_player1[1])])," ");
	
	$player1 = substr(trim($plist[trim($parts_player1[1])]),$seperator+1);
	$player2 = substr(trim($plist[trim($parts_player2[1])]),$seperator+1);
	$flag1 = substr(trim($plist[trim($parts_player1[1])]),0,$seperator);
	$flag2 = substr(trim($plist[trim($parts_player2[1])]),0,$seperator);
	
	$set1p1 = trim($court[2]);
	$set1p2 = trim($court[3]);
	if(trim($court[4])) $set2p1 = trim($court[4]);
	if(trim($court[5])) $set2p2 = trim($court[5]);
	if(trim($court[6])) $set3p1 = trim($court[6]);
	if(trim($court[7])) $set3p2 = trim($court[7]);
	$service = trim($court[8]);
#	print_r($court);


	// set red marker
	for($i=0;$i<9;$i++)
	{	
		if($set1p1==(21+$i) && $set1p2<(20+$i)) $winnerSet1 = 1;
		if($set1p2==(21+$i) && $set1p1<(20+$i)) $winnerSet1 = 2;
	}
	for($i=0;$i<9;$i++)
	{	
		if($set2p1==(21+$i) && $set2p2<(20+$i)) $winnerSet2 = 1;
		if($set2p2==(21+$i) && $set2p1<(20+$i)) $winnerSet2 = 2;
	}
	if($set1p1==30) $winnerSet1 = 1;	
	if($set1p2==30) $winnerSet1 = 2;
	if($set2p1==30) $winnerSet2 = 1;	
	if($set2p2==30) $winnerSet2 = 2;
	if($set3p1==30) $winnerSet3 = 1;	
	if($set3p2==30) $winnerSet3 = 2;
		if($set2p1=='-' && $winnerSet1>0) { $set2p1='0'; }
		if($set2p2=='-' && $winnerSet1>0) { $set2p2='0'; }
		if($set3p1=='-' && $winnerSet2>0 && $winnerSet1!=$winnerSet2) { $set3p1='0'; }
		if($set3p2=='-' && $winnerSet2>0 && $winnerSet1!=$winnerSet2) { $set3p2='0'; }	
	
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
	
}
?>
<r>
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
		<set1p1><?php echo $set1p1; ?></set1p1>
		<set1p2><?php echo $set1p2; ?></set1p2>
		<set2p1><?php echo $set2p1; ?></set2p1>
		<set2p2><?php echo $set2p2; ?></set2p2>
		<set3p1><?php echo $set3p1; ?></set3p1>
		<set3p2><?php echo $set3p2; ?></set3p2>
	</sets>
	<currentSet><?php echo $currentSet; ?></currentSet>
	<service><?php echo $service; ?></service>
	<winnerSet1><?php echo $winnerSet1; ?></winnerSet1>
	<winnerSet2><?php echo $winnerSet2; ?></winnerSet2>
	<winnerSet3><?php echo $winnerSet3; ?></winnerSet3>
</r>

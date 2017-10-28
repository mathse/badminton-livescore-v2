<?php
include('settings.php');
function sendToMeteorDB($collection,$object,$data) {
    echo $collection." ".$object." ".$data;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "http://localhost:3000/collectionapi/".$collection."/".$object);
    curl_setopt($ch,CURLOPT_HTTPHEADER, array('X-Auth-Token: 97f0ad9e24ca5e0408a269748d7fe0a0'));
    curl_setopt($ch,CURLOPT_POST, True);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, True);
    curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
    $r = curl_exec($ch);
    if(trim($r) == '{"message":"No Record(s) Found"}') {
        curl_setopt($ch,CURLOPT_URL, "http://localhost:3000/collectionapi/".$collection);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array('X-Auth-Token: 97f0ad9e24ca5e0408a269748d7fe0a0'));
        curl_setopt($ch,CURLOPT_POST, True);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, False);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POSTFIELDS, '{"_id":"'.$object.'", '.substr($data,1,-1).'}');
        curl_exec($ch);
    }
    curl_close($ch);
}

if(@$_GET['deviceid'])
{
	// x = delete device id
	@unlink('sessions/controller/'.$_GET['deviceid']);
	if($_GET['court']=='x')
	{
		@unlink('sessions/'.$_GET['deviceid']);
		@unlink('sessions/connections/'.$_GET['deviceid']);
//		@unlink('sessions/controller/'.$_GET['deviceid']);
	} else {
		if(trim($_GET['court'])=='photos')
		{
			$fd=fopen('sessions/controller/'.$_GET['deviceid'],'w');
			fputs($fd, '202');
			fclose($fd);
			exit;
		}
		if(trim($_GET['court'])=='sponsors')
		{
			$fd=fopen('sessions/controller/'.$_GET['deviceid'],'w');
			fputs($fd, '201');
			fclose($fd);
			exit;
		}
		if(trim($_GET['court'])=='reset')
		{
			$fd=fopen('sessions/controller/'.$_GET['deviceid'],'w');
			fputs($fd, '500');
			fclose($fd);
			exit;
		}
		if(substr($_GET['court'],1,4)==' / x')
		{
			$fd=fopen('sessions/controller/'.$_GET['deviceid'],'w');
			fputs($fd, '210');
			fclose($fd);
			exit;
		}
		if(substr($_GET['court'],0,4)=='x / ')
		{
			$fd=fopen('sessions/controller/'.$_GET['deviceid'],'w');
			fputs($fd, '220');
			fclose($fd);
			exit;
		}
//		if(is_numeric($_GET['']))
//		{

//		}

//        sendToMeteorDB("connections","device-".$_GET['deviceid'],'{"court" : "'.$_GET['court'].'","time":"'.time().'"}');
		$fd=fopen('sessions/connections/'.$_GET['deviceid'],'w');
		fputs($fd, $_GET['court']);
		fclose($fd);
	}
}
if(@$_GET['newgame'])
{
	$fd=fopen('sessions/courts/'.$_GET['court'],'w');
	for($set=1;$set<=$maxSets;$set++) {
		$sets[$set]['p1'] = '-';
		$sets[$set]['p2'] = '-';
		$sets[$set]['winner'] = 0;
	}
	$sets['p1'] = $_GET['p1']; $sets['p2'] = $_GET['p2'];
	fputs($fd, json_encode($sets));
	fclose($fd);

//    $parts_player1 = explode("-",$_GET['p1']);
//    $parts_player2 = explode("-",$_GET['p2']);
//    $plist = file('players/'.$parts_player1[0].'.txt');
//    $seperator = strpos(trim($plist[trim($parts_player1[1])])," ");
//    $player1name = substr(trim($plist[trim($parts_player1[1])]),$seperator+1);
//    $player2name = substr(trim($plist[trim($parts_player2[1])]),$seperator+1);
//    $player1flag = trim(str_replace($player1name,'',$plist[trim($parts_player1[1])]));
//    $player2flag = trim(str_replace($player2name,'',$plist[trim($parts_player2[1])]));
////    sendToMeteorDB("courts","court".$_GET['court'],'{"p1":"'.html_entity_decode($player1name).'","p2":"'.html_entity_decode($player2name).'","p1flag":"'.$player1flag.'","p2flag":"'.$player2flag.'"}');
//	$fd_matchcard=fopen('sessions/matchcards/'.date("Y-m-d",time())."-".str_replace("/","_",$parts_player1[0].'-court'.$_GET['court'].'-'.$player1.'-'.$player2).'-'.time().'.txt','a+');
//	 fputs($fd_matchcard,time().";".$_GET['player'].";".urlencode($_GET['value'])."\n");
//	 fclose($fd_matchcard);
}

if(@$_GET['player'])
{
	$sets = json_decode(file_get_contents('sessions/courts/'.$_GET['court']),true);

	for($set=1;$set<=$maxSets;$set++) {

		if (urlencode($_GET['value']) == '+' && $_GET['set'] == $set)
        {
            if ($sets[$set]['p1'] == '-' && $sets[$set]['p2'] == '-') {
                $sets[$set]['p1'] = 0;
                $sets[$set]['p2'] = 0;
            }
            $sets[$set]['p' . $_GET['player']]++;
        }
		if (urlencode($_GET['value']) == '-' && $_GET['set'] == $set && $sets[$set]['p' . $_GET['player']] > 0) $sets[$set]['p' . $_GET['player']]--;
	}
	$sets['service'] = $_GET['player'];

	$fd=fopen('sessions/courts/'.$_GET['court'],'w');
	fputs($fd, json_encode($sets));
	fclose($fd);

//	$parts_player1 = explode("-",$court[0]);
//	$parts_player2 = explode("-",$court[1]);
//	$plist = file('players/'.$parts_player1[0].'.txt');
//	$seperator = strpos(trim($plist[trim($parts_player1[1])])," ");
//    $player1name = substr(trim($plist[trim($parts_player1[1])]),$seperator+1);
//    $player2name = substr(trim($plist[trim($parts_player2[1])]),$seperator+1);
//    $player1flag = trim(str_replace($player1name,'',$plist[trim($parts_player1[1])]));
//    $player2flag = trim(str_replace($player2name,'',$plist[trim($parts_player2[1])]));
//	$player1 = str_replace(' ','%20',$player1name);
//	$player2 = str_replace(' ','%20',$player2name);
//
//	$s = $player1.";".$player2.";".trim($court[2]).";".trim($court[3]).";".trim($court[4]).";".trim($court[5]).";".trim($court[6]).";".trim($court[7]).";".$service.";";
////	$c = @file_get_contents("http://badminton-livescore.de/set.php?c=".$_GET['court']."&s=".$s);


//    print_r(substr(trim($plist[trim($parts_player1[1])]),));
    #$context  = stream_context_create($opts);
    #print_r($opts);
    #echo file_get_contents(); //, false, $context);

    // put all changed data to meteors mongo db
//    sendToMeteorDB("courts","court".$_GET['court'],'{"p1":"'.html_entity_decode($player1name).'","p2":"'.html_entity_decode($player2name).'","p1flag":"'.$player1flag.'","p2flag":"'.$player2flag.'","set1p1":"'.abs($court[2]).'","set1p2":"'.abs($court[3]).'","set2p1":"'.abs($court[4]).'","set2p2":"'.abs($court[5]).'","set3p1":"'.abs($court[6]).'","set3p2":"'.abs($court[7]).'","service":"'.$service.'"}');

#	if($_GET['court']==6){
#	 $fd_matchcard=fopen('sessions/matchcards/'.date("Y-m-d",time())."-".str_replace("/","_",$parts_player1[0].'-court'.$_GET['court'].'-'.$player1.'-'.$player2).'.txt','a+');
#	 fputs($fd_matchcard,time().";".$_GET['player'].";".urlencode($_GET['value'])."\n");
#	 fclose($fd_matchcard);
# }
}



?>

<?php

if($_GET['deviceid'])
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
				
		$fd=fopen('sessions/connections/'.$_GET['deviceid'],'w');
		fputs($fd, $_GET['court']);
		fclose($fd);
	}
}
if($_GET['newgame'])
{
	$fd=fopen('sessions/courts/'.$_GET['court'],'w');
	fputs($fd, $_GET['p1']."\n".$_GET['p2']."\n0\n0\n0\n0\n0\n0\n");
	fclose($fd);
}

if($_GET['player'])
{
	$court = file('sessions/courts/'.$_GET['court']);
	
	$fd=fopen('sessions/courts/'.$_GET['court'],'w');
	
	for($i=0; $i<3; $i++) {
		if(urlencode($_GET['value'])=='+' && $_GET['player']==1 && $_GET['set'] == ($i+1)) $court[2+($i*2)]=trim($court[2+($i*2)])+1;
		if(urlencode($_GET['value'])=='-' && $_GET['player']==1 && $_GET['set'] == ($i+1)) $court[2+($i*2)]=trim($court[2+($i*2)])-1;
		if(urlencode($_GET['value'])=='+' && $_GET['player']==2 && $_GET['set'] == ($i+1)) $court[3+($i*2)]=trim($court[3+($i*2)])+1;
		if(urlencode($_GET['value'])=='-' && $_GET['player']==2 && $_GET['set'] == ($i+1)) $court[3+($i*2)]=trim($court[3+($i*2)])-1;
	}
	
	$service = $_GET['player'];



	fputs($fd, 
		trim($court[0])."\n".
		trim($court[1])."\n".
		trim($court[2])."\n".
		trim($court[3])."\n".
		trim($court[4])."\n".
		trim($court[5])."\n".
		trim($court[6])."\n".
		trim($court[7])."\n".
		$service."\n"		
	);

	$parts_player1 = explode("-",$court[0]);
	$parts_player2 = explode("-",$court[1]);
	$plist = file('players/'.$parts_player1[0].'.txt');
	$seperator = strpos(trim($plist[trim($parts_player1[1])])," ");
	$player1 = str_replace(' ','%20',substr(trim($plist[trim($parts_player1[1])]),$seperator+1));
	$player2 = str_replace(' ','%20',substr(trim($plist[trim($parts_player2[1])]),$seperator+1));
	
	$s = $player1.";".$player2.";".trim($court[2]).";".trim($court[3]).";".trim($court[4]).";".trim($court[5]).";".trim($court[6]).";".trim($court[7]).";".$service.";";
//	$c = @file_get_contents("http://badminton-livescore.de/set.php?c=".$_GET['court']."&s=".$s);
	fclose($fd);
	
#	if($_GET['court']==6){
	 $fd_matchcard=fopen('sessions/matchcards/'.date("Y-m-d",time())."-".str_replace("/","_",$parts_player1[0].'-court'.$_GET['court'].'-'.$player1.'-'.$player2).'.txt','a+');
	 fputs($fd_matchcard,time().";".$_GET['player'].";".urlencode($_GET['value'])."\n");
	 fclose($fd_matchcard);
# }
}



?>
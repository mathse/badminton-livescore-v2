<?php
$id = "70B65F05-BA8E-4302-BB7B-055B4475F93A";
$postdata = http_build_query(
    array(
        'dlFilter' => '2'
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

$file = file_get_contents("http://www.turnier.de/sport/teams.aspx?id=".$id, false, $context);
$regex = "/".$id."&team=([0-9]+)\">([\w ]+)/";
preg_match_all ($regex, $file, $output);
$gender = "MS";
foreach($output[1] as $tkey => $team) {
    $teamUrl = "http://www.turnier.de/sport/teamrankingplayers.aspx?id=".$id."&tid=".$team;
    $teamFile = file_get_contents($teamUrl);
    $teamRegEx = "/<td>[\d]+-([\d])+[\d\w\-]*<\/td><td><\/td><td><a href=\"player.aspx\?id=[\d\w\-]+&player=[\d]+\">([äöü ÄÖÜ \w\d,\-\.]+)<\/a><\/td><td class=\"flagcell\">([\w\d\-\"<>\]\[ \/\.=äöüÄÖÜ\(\)]*)<\/td><td>[\d]+-[\d]+/"; //
    //<img src="//static.tournamentsoftware.com/images/flags/16/POL.png" class="intext flag" width="16" height="14" alt="Polen" title="Polen"/><span class="printonly flag">[POL] </span></td><td>03-018862</td><td></td><td>Ja</td><td></td><td></td>
    preg_match_all ($teamRegEx, $teamFile, $teamOutput);
    foreach($teamOutput[0] as $key => $teamMember) {
        if($teamOutput[1][$key] < $lastGender) { if($gender=="MS") { $gender = "WS"; } else { $gender = "MS"; } }
        $lastGender = $teamOutput[1][$key];
        $flag = substr(strip_tags($teamOutput[3][$key]),1,3);
        if(!$flag) $flag = "GER";
        $allPlayers[str_replace(" ","",$output[2][$tkey])][$gender][] = htmlentities($teamOutput[2][$key]);
    }
}

foreach($allPlayers as $team => $player) {
    foreach(array("MS","WS") as $dis) {
        for($l=1;$l<count($player[$dis]);$l++) {
            for($i=$l;$i<count($player[$dis]);$i++) {
                $n1 = explode(", ",$player[$dis][($l-1)]);
                $n2 = explode(", ",$player[$dis][$i]);
                if($dis == "MS") {
                    $allPlayers[$team]["MD"][] = $n1[0]." / ".$n2[0];
                } else {
                    $allPlayers[$team]["WD"][] = $n1[0]." / ".$n2[0];
                }
            }
        }
    }
    foreach(array("XD") as $dis) {
        for($l=0;$l<count($player["MS"]);$l++) {
            for($i=0;$i<count($player["WS"]);$i++) {
                $n1 = explode(", ",$player["MS"][$l]);
                $n2 = explode(", ",$player["WS"][$i]);
                $allPlayers[$team]["XD"][] = $n1[0]." / ".$n2[0];
            }
        }
    }
}

foreach($allPlayers as $team => $player) {
    foreach(array("MS","WS","MD","WD","XD") as $dis) {
        foreach ($player[$dis] as $p) {
            $fd = fopen('../../players/'.$dis.'.txt','a+');

            fwrite($fd,$team." ".$p."\n");
            fclose($fd);
        }
    }
}
//print_r($allPlayers);
print_r($sortedPlayers);
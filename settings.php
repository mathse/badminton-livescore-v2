<?php
// the number of courts
error_reporting(-1);
ini_set('display_errors', 'Off');

$courts=12;
$updateInterval = '1';
$width['android'] = 1100;
$height['android'] = 800;

if(@$_GET['direct']) { $_GET['direct'] = 'direct-'; }

if(@$_GET['debugid']) {
	$deviceid = @$_GET['direct'].str_replace("127.0.0.1-","",$_SERVER['REMOTE_ADDR'].'-'.@$_GET['debugid']);
	//$deviceid = $_GET['debugid'];
} else {
	$deviceid = $_SERVER['REMOTE_ADDR'];
}
$maxpoints=21;

// autoswitch "flag" - altersklassen bei meisterschaften
$sameNationTrigger=true;

// tournament ID/Link
$tTitle = '28. Deutsche Meisterschaften';
$tID = '88CEA26F-E7B8-425E-A08B-54CF080FEBF7';
//$tLink = 'tournamentsoftware.com';
$tLink = 'turnier.de';

// draw rotation
//$nextSite = array(-1=>1, 1=>2, 2=>6, 6=>7, 7=>11, 11=>12, 12=>16, 16=>17, 17=>21, 21=>22, 22=>26, 26=>27, 27=>31, 31=>32, 32=>36, 36=>37, 37=>41, 41=>42, 42=>1);
//$nextSite = array(-1=>3, 3=>4, 4=>8, 8=>9, 9=>13, 13=>14, 14=>18, 18=>19, 19=>23, 23=>24, 24=>28, 28=>29, 29=>33, 33=>34, 34=>38, 38=>39, 39=>43, 39=>3);
$nextSite = array(-1=>5, 5=>10, 10=>15, 15=>20, 20=>25, 25=>30, 30=>35, 35=>40, 40=>44, 44=>5);
/*
#### #### #### #### 
#10# # 7# # 4# # 1# 
#### #### #### #### 

#### #### #### #### 
#  # #  # #  # # 2# 
#### #### #### #### 

#### #### #### #### 
#  # #  # #  # # 3# 
#### #### #### #### 

   #############
    matchcontol
*/

$courtlayout = array(
 array(10,7,4,1),
 array(11,8,5,2),
 array(12,9,6,3),
);

/*
$courtlayout = array(
 array(7,4),
 array(8,5),
);
*/


//$courtlayout = array(
// array(6,4,2),
// array(5,3,1),
//);



//$courtlayout = array(
// array(1,2),
//);




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

// tournament ID
$tID = '88CEA26F-E7B8-425E-A08B-54CF080FEBF7';

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




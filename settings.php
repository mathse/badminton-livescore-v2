<?php
// the number of courts
$courts=13;
$updateInterval = '1';
$width['android'] = 1100;
$height['android'] = 800;

$deviceid = $_SERVER['REMOTE_ADDR'].'_'.$_GET['debugid'];

$maxpoints=21;

// autoswitch "flag" - altersklassen bei meisterschaften
$sameNationTrigger=true;

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
/*
$courtlayout = array(
 array(10,7,4,1),
 array(11,8,5,2),
 array(12,9,6,3),
);
*/
$courtlayout = array(
 array(7,4),
 array(8,5),
);
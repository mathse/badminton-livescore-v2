<?php
include('settings.php');

// status 200 ok
// status 201 show sponsoren
// status 202 show images
// status '' show misc/error

if(file_exists('sessions/controller/'.$deviceid))
{
	echo trim(file_get_contents('sessions/controller/'.$deviceid));
	exit;
}

if(file_exists('sessions/connections/'.$deviceid))
{
	echo "200";	
} else {
	if($_GET['debugid']) {
		echo "200";
	} else {
		echo "400";	
	}
}	
?>
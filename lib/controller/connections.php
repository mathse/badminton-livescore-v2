<?php
header("Content-type: text/xml");
?>
<connections>
<?php
$dir = '../../sessions';
$files = scandir($dir);
foreach($files as $file) {
	if(substr($file,0,1) == '.' || $file == '..' || $file == 'connections' || $file == 'courts' || $file == 'controller' || substr($file,-2,1)=="__") continue;	
	?><connection><name><?php	
	echo $file;
	?></name><court><?php
	echo @file_get_contents($dir.'/connections/'.$file);
	?></court><type></type></connection><?php


}
?>
</connections>
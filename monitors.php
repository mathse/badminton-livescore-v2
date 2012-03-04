<table>
<?php
include('settings.php');
	echo 'meine ip: '.$deviceid.' / freier speicher: '.round(diskfreespace('./')/1024/1024,2).'Mb';
$files = scandir('sessions');

foreach($files as $file)
{
	if(substr($file,0,1) == '.' || $file == '..' || $file == 'connections' || $file == 'courts' || $file == 'controller') continue;	
	echo "<tr><td>";
	$now = time();
	$session = file_get_contents('sessions/'.$file);
	if(($session+30) > $now) { echo '<input type="button" style="" value="'.$file.'">'; }
	else { echo '<input type="button" style=" background: red" value="'.$file.' - offline">'; }
	
	for($i=0;$i<$courts;$i++) {
		
		if(file_exists('sessions/connections/'.$file))
		{
			
				$monitorconnection = file_get_contents('sessions/connections/'.$file);
				if(($i+1)==$monitorconnection) { $bg = 'background-color: blue'; }
				if($bg) { $enabled=true; }
		}
		if(file_exists('sessions/controller/'.$file) && $monitorconnection == ($i+1))
		{
			 
			$bg = '';
			$controllerStatus = trim(file_get_contents('sessions/controller/'.$file));
			if($controllerStatus == '210') $bgL = 'background-color: blue';
			if($controllerStatus == '220') $bgR = 'background-color: blue';
		}
		echo '</td><td><input class="courtselect" alt="courtselect" type="button" name="'.$file.'" style="width: 6em; '.$bg.'" value="'.($i+1).'" onclick="javascript:pushButton(this,false)">';
		if($enabled) {
			echo '<br><input class="courtselect" alt="courtselect" type="button" name="'.$file.'" style="width: 3em; '.$bgL.'" value="'.($i+1).' / x" onclick="javascript:pushButton(this,false)">';
			echo '<input class="courtselect" alt="courtselect" type="button" name="'.$file.'" style="width: 3em; '.$bgR.'" value="x / '.($i+1).'" onclick="javascript:pushButton(this,false)">';
		}
		echo "</td><td>";
		$bg = ''; $bgL = ''; $bgR = ''; $enabled=false;	
	}
	echo '&nbsp;<input class="courtselect" alt="courtselect" type="button" name="'.$file.'" style="" value="x" onclick="javascript:pushButton(this,false)">';	
	echo '</td><td><input class="courtselect" alt="courtselect" type="button" name="'.$file.'" style=" " value="sponsors" onclick="javascript:pushButton(this,false)">';
	echo '</td><td><input class="courtselect" alt="courtselect" type="button" name="'.$file.'" style=" " value="reset" onclick="javascript:pushButton(this,false)">';
	echo "</tr>";
}
?>
</table>
<!-- <br><br><input type="button" onclick="window.open('index.php?type=output&debugid=<?php echo time(); ?>','mywindow<?php echo time(); ?>','width=400,height=200')" value="open new debug monitor">
-->
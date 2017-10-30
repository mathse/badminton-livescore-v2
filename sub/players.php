<?php

    if($_GET['file']) {
        echo '<div>saving file '.$_GET['file'].'..<br></div>';
        $fd = fopen('./players/'.$_GET['file'],'w');
        if($_GET['file'] == 'overview.php') {
            fwrite($fd, htmlspecialchars_decode($_POST['players']));
        } else {
            fwrite($fd, htmlentities($_POST['players']));
        }
        fclose($fd);
    }

    foreach(scandir('./players/') as $file) {
        if($file == '.' || $file == '..' || substr($file,-1,1) == '~') continue;
        ?>
        <div style="float:left">
            <?php echo 'file: '.trim($file);?>
            <form action="index.php?type=players&file=<?php echo $file; ?>" method="post">
                <?php
                if($file == 'overview.php') { $width=600; } else { $width=300; }
                ?>
                <textarea name="players" style="color: black; width: <?php echo $width; ?>px; height: 200px; margin: 5px;"><?php echo file_get_contents('./players/'.$file); ?></textarea>
                <br>
                <input type="submit" value="save">
            </form>

        </div>
        <?php
    }

	?>
	<div style="clear: both">
	<div>
	<table>
	<?php
	$games = array("1. HD","DD","2. HD","DE","Mixed","1. HE","2. HE","3. HE");

	foreach($games as $game) { ?>
		<tr><td><?php echo $game; ?></td><td>
		<?php
		switch ($game) {
			case "1. HD":
			case "2. HD":
			$file = "HD";
			break;
			case "1. HE":
			case "2. HE":
			case "3. HE":
			$file = "HE";
			break;
			case "Mixed":
			$file = "MX";
			break;
			default:
			$file = $game;
			//break;
		}

		?>
		<select>
		<option>---</option>
		<?php
		$f = file('players/'.$file.'.txt');
		//print_r($f);
		if (!empty($line)) {
			foreach($line as $f) {
            ?><option><?php echo $line; ?></option><?php
            }
		}
		?>
		</select>
		</td><td></td><td></td></tr>
	<?php } ?>
	</table>
	</div>
	</div>

?>

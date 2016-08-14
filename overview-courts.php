<html sytle="cursor: none;">
<meta name="google" value="notranslate">
<?php
include('settings.php');
$rows = count($courtlayout);
$cols = count($courtlayout[0]);

for($i=0;$i<$rows;$i++) { $rows_string .= (round(100/$rows)-1)."%,1%,"; }
for($i=0;$i<$cols;$i++) { $cols_string .= round(100/$cols)."%,"; }




?>
<frameset rows="<?php echo $rows_string; ?>" border="0">
	<?php for($rows_i=0;$rows_i<$rows;$rows_i++) { ?>
		<div style="position: absolute">asd</div>
		<frameset cols="<?php echo $cols_string; ?>">
			<?php for($cols_i=0;$cols_i<$cols;$cols_i++) { ?>
				<frame src="index.php?type=output&debugid=<?php echo $courtlayout[$rows_i][$cols_i]; ?>&style=2&direct=1">
			<?php } ?>
		</frameset>
		<frameset cols="<?php echo $cols_string; ?>">
			<?php for($cols_i=0;$cols_i<$cols;$cols_i++) { ?>
				<frame src="check.php?c=<?php echo $courtlayout[$rows_i][$cols_i]; ?>">
			<?php } ?>
		</frameset>
	<?php } ?>
</frameset>


</html>


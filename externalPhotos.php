<html>
<body>

<center>
<table style="height: 100%; width: 100%;">
<td align='center'>
	<script type="text/javascript" src="js/crossfade.js"></script>
	<ul id="gallery" style='list-style-type:none; margin: auto;'>
		<?php 
			$fotos = scandir('img/'.$_GET['source'].'/');
			
			foreach($fotos as $foto)
			{
				if($foto == '.' || $foto == '..') continue;
				?><li style='align: center;'><img src='img/<?php echo $_GET['source']; ?>/<?php echo $foto; ?>'></li><?php
			}		
		?>
	</ul>
	</td>
	</table>
	</body>
</html>
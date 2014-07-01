<?php
include('../../settings.php');
?>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>

<style type="text/css">
* {
	background-color: black;
	color: white;	
}
.court { 
	width: <?php echo ((100/count($courtlayout[0]))-5) ?>%;
	height: <?php echo ((100/count($courtlayout))-15) ?>%;
	border: 2px dashed gray;
	padding: 1%;
	margin: 1%;
}
.displays { 
	width: 93%;
	height: 8%;
	border: 2px dashed gray;
	padding: 1%;
	margin: 1%;
	//margin-left: auto; margin-right: auto;
}
.display {
	padding: 1%;
	margin: 1%;
	border: 2px dotted gray;
	float: left;	
}
</style>

<script type="text/javascript">
new PeriodicalExecuter(function(pe) {
	new Ajax.Request("../controller/connections.php",{
		onSuccess: function(r) {
			var root = r.responseXML;
			$('#displays').innerHTML = "";
			//alert();
			for(var i = 0; i < root.getElementsByTagName("connection").length; i++)
			{
				if(root.getElementsByTagName("connection")[i].nodeType != 1) continue;
				var item = root.getElementsByTagName("connection")[i];
				var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
				if (item.getElementsByTagName("court")[0].childNodes.length == 0)	{		
					var court = 0;				
				} else {
					var court = item.getElementsByTagName("court")[0].firstChild.nodeValue;
				}
				
				var div = document.createElement("div");
				div.innerHTML = name;
				div.className = "display";
				
				if (court == 0) {
					$('#displays').appendChild(div);	
				} else {
					$('#courtID'+court).innerHTML = '';
					$('#courtID'+court).appendChild(div);
				}
					
			}	
		}
	});
},1);

  $(function() {

$('#displays').draggable();
} );
</script>



<div style="margin-left: auto; margin-right: auto;">
<?php
foreach ($courtlayout as $r) {
	foreach ($r as $c) {
		?><div class="court" style="float: left">Court <?php echo $c; ?>
			<div id="courtID<?php echo $c; ?>"></div>		
		</div><?php
	}
	?><div style="clear: both"></div><?php
}
?>
	<div class="displays" id="displays">
		<?php
		for($i=0;$i<5;$i++) {
			?><div class="display">D<?php echo $i; ?></div><?php  	
		}
		?>
	</div>
</div>

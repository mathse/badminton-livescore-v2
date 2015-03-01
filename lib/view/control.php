<?php
include('../../settings.php');
?>
<script type="text/javascript" src="../../js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/jquery.periodic.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.touch-punch.min.js"></script>

<style type="text/css">
* {
	background-color: black;
	color: white;
    margin: 0px;
}
.court {
    background-color: darkslategray;
	width: <?php echo ((100/count($courtlayout[0]))-4) ?>%;
	height: <?php echo ((75/count($courtlayout))-4) ?>%;
	/*border: 2px dashed gray;*/
	padding: 1%;
	margin: 1%;
}
#displays { 
	/*width: 50px;*/
	height: 50px;
    background-color: darkslategray;

    /*border: 2px dashed gray;*/
	margin: 1%;
    padding: 1%;
	/*//margin-left: auto; margin-right: auto;*/
}
.display {
	width: 80px;

	/*height: 50px;*/
    text-align: center;
    margin: 10px;
    padding-top: 15px;
    padding-bottom: 15px;
    /*height: 10%;*/
	/*border: 2px dotted gray;*/
	float: left;
    z-index: 1000;
}
</style>

<script type="text/javascript">
    function toggleColor() {
        if($('#colorState').val() == "true") {
            $.ajax({url: '../controller/meteorApi.php?bgtime={"value":"0"}'});
            $('#colorState').val("false");

        } else {
            $.ajax({url: '../controller/meteorApi.php?bgtime={"value":"1"}'});
            $('#colorState').val("true");
        }
    }
    function toggleAds() {
        if($('#adsState').val() == "true") {
            $.ajax({url: '../controller/meteorApi.php?showAds={"value":"none"}'});
            $('#adsState').val("false");

        } else {
            $.ajax({url: '../controller/meteorApi.php?showAds={"value":"show"}'});
            $('#adsState').val("true");
        }
    }

    function setPoint(court, player, set, value) {
        $.ajax({url: '../../setcourt.php?court='+court+'&player='+player+'&set='+set+'&value='+value});
    }

    function changeText() {
        $.ajax({url: '../controller/meteorApi.php?textToShow={"value":"'+$('#adsText').val().replace(/"/g,"'").replace(/\n/g,"<br>")+'"}'});
    }
</script>

<div style="margin-left: auto; margin-right: auto; " id="courts">
<?php
foreach ($courtlayout as $r) {
	foreach ($r as $c) {
		?><div class="court" style="float: left; position: relative">Court <?php echo $c; ?>
			<div id="courtID<?php echo $c; ?>"></div>
            <div style="position: absolute; bottom: 10px; right: 10px; ">
                <table style="background-color: transparent">
                    <tr>
                        <?php for($p=1;$p<3;$p++) {
                            for($s=1;$s<4;$s++) {
                                ?>
                                <td style="background-color: transparent">
                                    <button style="width: 25px" onclick="setPoint(<?php echo $c; ?>,<?php echo $p; ?>,<?php echo $s; ?>,'+')">+</button>
                                    <br>
                                    <button style="width: 25px" onclick="setPoint(<?php echo $c; ?>,<?php echo $p; ?>,<?php echo $s; ?>,'-')">-</button>
                                </td>
                                <?php
                                }
                                ?></tr><tr><?php
                            }
                        ?>
                    </tr>
                </table>
            </div>
		</div>
        <script type="javascript">


        </script>
        <?php
	}
	?><div style="clear: both"></div><?php
}
?>
    <div class="court" style="float: left; height: 50px; width: 15%">2x
        <div id="courtID-2"></div>
    </div>
    <div class="court" style="float: left; height: 50px; width: 15%">6x
        <div id="courtID-6"></div>
    </div>
    <div class="court" style="float: left; height: 50px; width: 15%">12x
        <div id="courtID-12"></div>
    </div>
    <div class="displays" style="float: left; width: 20%" id="displays">

    </div>    <div style="clear: both"></div>

    <div style="position: absolute; right: 20px; bottom: 20px">
        <textarea  id="adsText"  onkeyup="changeText()" style="width: 100%; height: 100px"></textarea><br>
        <button style="height: 30px" onclick="toggleAds()">Werbung / Text</button>
        <input style="display: none" type="text" id="adsState" value="false">
        <button style="height: 30px" onclick="toggleColor()">Displays einf&auml;rben</button>
        <input style="display: none" type="text" id="colorState" value="false">
    </div>
</div>

<script type="text/javascript">
    $.periodic({period: 500, decay: 1.2, max_period: 60000}, function() {
        $.ajax({
            url: "../controller/connections.php"
        }).done(function (data) {
            var root = data;
            //$('#displays').text("");

            // flush court contents
            for (var i=0; i < <?php echo $courts; ?>; i++) {
                $('#courtID'+i).text("");
                $('.court').droppable({
                    accept: '.display',
                    drop: function(ev,ui) {
//                        console.log(ev);
//                        console.log(ui);
                        console.log(ev.toElement.id + " dropped on " + ev.target.firstElementChild.id);
//                        new Ajax.Request();
                        $.ajax({
                            url: "../../setcourt.php?deviceid=" + ev.toElement.id + "&court=" + ev.target.firstElementChild.id.replace(/courtID/,'')
                        })
                    }
                });
            }


            for(var i = 0; i < root.getElementsByTagName("connection").length; i++)
            {
                if(root.getElementsByTagName("connection")[i].nodeType != 1) continue;
                var item = root.getElementsByTagName("connection")[i];
                var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
                // get the color somehow
                if (item.getElementsByTagName("court")[0].childNodes.length == 0)	{
                    var court = 0;
                } else {
                    var court = item.getElementsByTagName("court")[0].firstChild.nodeValue;
                }

//            console.log("map " + name + " to c:" + court);

                if (court == 0 ) { // || document.getElementById('#courtID'+court) == null
                    appendto = '#displays';
                } else {
                    appendto = '#courtID'+court;
                }

                //console.log(document.getElementById(name));

                display_name = name.replace(/192.168.1./,'').replace(/-$/,'');
                var color = $.ajax({url: '../controller/meteorApi.php?colorForDevice=device-' + name, async: false}).responseText;
                if(color == "") {
                    color = "black";
                }
                if(document.getElementById(name) == null) {
                    jQuery('<div/>', {
                        text: display_name,
                        id: name,
                        class: 'display'
                    }).css('backgroundColor', color).css('border','5px dotted black').appendTo(appendto).draggable( {  stop: function(ev,ui) { console.log(ev); } }); //replace the color here
                }
            }
        });
    });


</script>

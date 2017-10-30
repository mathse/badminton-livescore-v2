<html>
   <meta name="apple-mobile-web-app-capable" content="yes" />
   <?php if(@$_GET['type']!='control') { ?>
   <meta name="viewport" content=" user-scalable=0;" />
   <?php } ?>
   <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
   <?php
   include('settings.php');
   ?>
<style type="text/css">
<!--
* {
    <?php  if($_GET['type']=='output') { ?> cursor: none; <?php } ?>
	//font-size: 112%;
	color: white;
	scrolling: no;
	font-family: Arial;
<?php
if($_GET['type']=='output' && $_GET['style']==2) {
	echo "zoom: 0.9; cursor: none;";
}
?>
}
body {
    -webkit-user-select: none;
	background: black;
	text-align: center;
	padding: 0;
	margin: 0;
	overflow:hidden;
}
img {
<?php
if($_GET['type']=='output' && $_GET['style']==2) {
	//echo "height: 40%; ";
}
?>
}
a { text-decoration: none }
input, select { font-size: 1em;  background: black; border: 5px solid white; -moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px;}
select { font-size: 1.1em; }
#currentEvent, #currentCourt, #currentPlayers, #currentSet {  background: black; border: 0px; color: gray; -webkit-border-radius: 10px; border-radius: 10px;}
#main { height: 100%; }

#input {
    height: 80%; margin: 15px auto; width: 90%; text-align: center; border-radius: 0px;
    -webkit-appearance: none;
}
<?php if($_GET['c']==12) { ?>
#pl, #pm, #pr { font-size: 1000%; width: 30%; line-height:80%}
<?php } else { ?>
#pl, #pm, #pr { font-size: 1400%; width: 30%; line-height:80%}
<?php } ?>
.settingslabel { font-size: 2em }
#inputName1, #inputName2 { -moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px; }
#output { height: 100%; width: 98%; font-size: 1300%; padding: 0px; text-align: center; line-height: 80%; }
#output td { -moz-border-radius: 20px}
#namePlayer1, #namePlayer2 { font-size: 40%;  line-height: 70% }

.scoreboard { background-color: #111; border: 10px solid #111; width: <?= (100/$maxSets); ?>%;  -webkit-border-radius: 10px; border-radius: 10px;}
-->
</style>


<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects"></script>

<script type="text/javascript">

var sponsors=0;
var photos=0;
var switched=0;
//var dialogShown=false;

if (navigator.userAgent.match(/Android/i)) {
	 document.height=630;
    window.scrollTo(0,1);
  }


function getflags(name,flagsi,seperator) {
    // console.log(name + " " + flagsi);
    if(name!='AAA')
    {
       allflags = ""
       flags = flagsi.split('|');
       for (var f = 0; f < flags.length; f++) {
           allflags = allflags + "<img style='border:1px solid white; border-radius: 5px; height:100px' src='img/flags/" + flags[f] + ".png' style='border: 1px solid white'> ";
       }

       return allflags + seperator + name;
    } else {
       return name.replace(/-lt-/gi,"<").replace(/-gt-/gi,">");
    }
}

function pushButton(v,disappear)
{


	for(var i = 0; i < document.getElementsByName(v.name).length; i++)
	{
		document.getElementsByName(v.name)[i].style.backgroundColor = 'black';
	}
	if(disappear)
	{
		new Effect.Highlight(v, { startcolor: '#0000ff', endcolor: '#000000' });
	} else {
		$(v).style.backgroundColor = 'blue';
	}

    if(v.value == 'settings')
    {
        $('settings').show();
        new Ajax.Request("info-draw/matches.php?type=xml",{
                onSuccess: function(r) {
                    $('selectMatch').innerHTML = r.responseText;
                    $('matchloading').hide();
                    $('player1').show(); $('player2').show(); // show player selector
                }
            }
        );
    }



	if(v.name == 'event')
	{
		new Ajax.Request("getPlayers.php?event="+v.value,{
				onSuccess: function(r) {
					$('selectNation1').innerHTML = r.responseText; $('selectNation2').innerHTML = r.responseText; // set nations
					$('selectPlayer1').innerHTML = ''; $('selectPlayer2').innerHTML = ''; // reset players
					$('player1').show(); $('player2').show(); // show player selector
				}
			}
		);
		$('currentEvent').value = v.value;
		$('eventCheck').show();
	}

//    if(v.name == 'selectMatch') {
//        var event = v.value.substring(0,2);
//        var flag = v.value.substring(3,6);
//        var match = v.value.substring(7);
//
//        for(var i = 0; i < document.getElementsByName('event').length; i++) {
//            if(document.getElementsByName('event').item(i).value == event) {
//                document.getElementsByName('event').item(i).click();
//            }
//        }
//
////        for(var i = 0; i < 1000; i++) {
////            console.log($('selectNation1').options.length);
////            $('selectNation1').value = flag;
////        }
//        setTimeout(function () {
//            $('selectNation1').value = flag;
//        },0);
////        $('selectNation2').value = flag;
//
//
//    }

	if(v.name == 'court')
	{
		$('currentCourt').value = v.value;

		$('courtCheck').show();
	}
	if(v.name == 'selectNation1')
	{
		new Ajax.Request("getPlayers.php?event="+$('currentEvent').value+"&nation="+$('selectNation1').value,{
				onSuccess: function(r) {
					$('selectPlayer1').innerHTML = r.responseText;
					<?php if($sameNationTrigger) { echo "$('selectPlayer2').innerHTML = r.responseText;"; } ?>
				}
			}
		);
	}
	if(v.name == 'selectNation2')
	{
		new Ajax.Request("getPlayers.php?event="+$('currentEvent').value+"&nation="+$('selectNation2').value,{
				onSuccess: function(r) {
					$('selectPlayer2').innerHTML = r.responseText;
				}
			}
		);
	}
	if(v.name == 'selectPlayer1') // set checkmark when player 1 is set
	{
		$('playerCheck1').show();
	}
	if(v.name == 'selectPlayer2') // set checkmark when player 2 is set
	{
		$('playerCheck2').show();
	}
	if(v.name == 'closeSettings')  // close settings and set values to main input
	{
		$('currentPlayers').value = $('selectPlayer1').value+"|"+$('selectPlayer2').value;
		$('settings').hide();
		$('settingsButton').hide();

		$('inputButtons').show();

		$('inputSet1').style.backgroundColor = 'blue';
		$('currentSet').value = '1';
		new Ajax.Request("setcourt.php?newgame=1&court="+$('currentCourt').value+"&p1="+$('selectPlayer1').value+"&p2="+$('selectPlayer2').value);

	}

	// show close button when all settings where set
	try
	{
		if($('eventCheck').style.display == '' && $('courtCheck').style.display == '' && $('playerCheck1').style.display == '' && $('playerCheck2').style.display == '')
		{ $('closeSettings').show(); $('settingsinfo').hide(); }
	} catch(r) {}


	if(v.alt=='courtselect')
	{
		//alert("setcourt.php?deviceid="+v.name+"&court="+v.value);
		new Ajax.Request("setcourt.php?deviceid="+v.name+"&court="+v.value);
	}

	if(v.name=='pointP1')
	{
		if($('currentSet').value=='') { $('currentSet').value = 1; $('inputSet1').style.backgroundColor = 'blue'; }
		new Ajax.Request("setcourt.php?court="+$('currentCourt').value+"&value="+v.value+"&player=1&set="+$('currentSet').value);
	}
	if(v.name=='pointP2')
	{
		if($('currentSet').value=='') { $('currentSet').value = 1; $('inputSet1').style.backgroundColor = 'blue'; }
		new Ajax.Request("setcourt.php?court="+$('currentCourt').value+"&value="+v.value+"&player=2&set="+$('currentSet').value);
	}
	if(v.name=='pointP1' || v.name=='pointP2')
	{

		var a = (eval($('pl').innerHTML+v.value+"1"));
		var b = (eval($('pr').innerHTML+v.value+"1"));
		if(switched==0) {
			if(v.name=='pointP1') {	$('pl').innerHTML = "<span style='color: #C1B7F3'>" + a + "</span>"; }
			if(v.name=='pointP2') {	$('pr').innerHTML = "<span style='color: #C1B7F3'>" + b + "</span>"; }
		} else {
			if(v.name=='pointP2') {	$('pl').innerHTML = "<span style='color: #C1B7F3'>" + a + "</span>"; }
			if(v.name=='pointP1') {	$('pr').innerHTML = "<span style='color: #C1B7F3'>" + b + "</span>"; }
		}
	}
	if(v.name=='set')
	{
		$('currentSet').value = v.value;
	}

	if(v.value=='change ends')
	{
		if(switched==0) { switched=1; } else { switched=0;}
		$('pb1').toggle(); $('pb2').toggle(); $('pb3').toggle(); $('pb4').toggle();
		$('pb5').toggle(); $('pb6').toggle(); $('pb7').toggle(); $('pb8').toggle();
	}
	if(v.name=='zoomincrease' || v.name=='zoomdecrease')
    {
        //console.log("setzoom.php?type=&zoom=");
        new Ajax.Request("setzoom.php?type=" + v.alt + "&zoom=" + (parseInt($('zoomvalue_' + v.alt).value) + (parseInt(v.value+"1") *10)));

    }

}

new PeriodicalExecuter(function(pe) {

<?php if($_GET['type']=='output') { ?>

	new Ajax.Request("controller.php?debugid=<?php echo $_GET['debugid']; ?>",{
			onSuccess: function(r) {
				// status 200 ok
				// status 201 show sponsoren
				// status 202 show images
				// 210 show names only
				// 220 show score only
				// 500 reload code of a monitor
				// status '' show misc/error
				// alert(r.responseText);
				var status = r.responseText;
				if(status == '200') {
					$('sponsoren').hide(); $('misc').hide(); $('images').hide();
					if(serv==0) {
						$('tblScore1').hide();
						$('tblScore2').hide();
					} else {
						$('tblScore1').show();
						$('tblScore2').show();
					}

//					$('tblNames1').show(); $('tblNames2').show();
					$('tblNames1').show();
					$('tblNames2').show();
					photos=0;
				}
				if(status == '201') { $('sponsoren').show(); $('misc').hide(); $('images').hide(); }
				if(status == '202') {
						$('sponsoren').hide(); $('misc').hide(); $('images').show();
						if(photos==0)
						{
							$('images').innerHTML = '<iframe src="externalPhotos.php?source=photos" width="100%" height="100%" name="SELFHTML_in_a_box"></iframe>';
							photos=1;
						}
				}

				if(status == '210')
					{
						$('sponsoren').hide(); $('misc').hide(); $('images').hide();
						$('tblScore1').hide(); $('tblScore2').hide(); $('tblNames1').show(); $('tblNames2').show();
					}

				if(status == '220')
					{
						$('sponsoren').hide(); $('misc').hide(); $('images').hide();
						$('tblScore1').show(); $('tblScore2').show(); $('tblNames1').hide(); $('tblNames2').hide();

					}

				if(status == '400') { $('sponsoren').hide(); $('misc').show(); $('images').hide(); }

				if(status == '500') { window.location.reload(); }
			}
		}
	);



	new Ajax.Request("output.php?debugid=<?php echo $_GET['debugid']; ?>&direct=<?php echo $_GET['direct']; ?>",{
			onSuccess: function(r) {
				var root = r.responseXML;
				for(var i = 0; i < root.childNodes.length; i++)
				{
					if(root.childNodes[i].nodeType != 1) continue;
					var item = root.childNodes[i];
					serv = 0;
					try
					  {
							serv = item.getElementsByTagName("service")[0].firstChild.nodeValue;
					  }
					catch(err)
					  {
					  //Handle errors here

					  }


					 if(item.getElementsByTagName("flag1")[0].firstChild.nodeValue!='AAA')
					 {
                        allflags = ""
                        flags = item.getElementsByTagName("flag1")[0].firstChild.nodeValue.split('|');
                        for (var f = 0; f < flags.length; f++) {
                            allflags = allflags + "<img style='height:100px' src='img/flags/" + flags[f] + ".png' style='border: 1px solid white'> ";
                        }

                        $('namePlayer1').innerHTML = allflags + ' ' + item.getElementsByTagName("player1")[0].firstChild.nodeValue;
					 } else {
					 	$('namePlayer1').innerHTML = item.getElementsByTagName("player1")[0].firstChild.nodeValue.replace(/-lt-/gi,"<").replace(/-gt-/gi,">");
					 }
                    // $('namePlayer1').innerHTML = flags(item.getElementsByTagName("player1")[0].firstChild.nodeValue,item.getElementsByTagName("flag1")[0].firstChild.nodeValue);
					 if(item.getElementsByTagName("flag2")[0].firstChild.nodeValue!='AAA')
					 {
                         allflags = ""
                         flags = item.getElementsByTagName("flag2")[0].firstChild.nodeValue.split('|');
                         for (var f = 0; f < flags.length; f++) {
                             allflags = allflags + "<img style='height:100px' src='img/flags/" + flags[f] + ".png' style='border: 1px solid white'> ";
                         }
						 $('namePlayer2').innerHTML = allflags + ' ' + item.getElementsByTagName("player2")[0].firstChild.nodeValue;
					 } else {
						 $('namePlayer2').innerHTML = item.getElementsByTagName("player2")[0].firstChild.nodeValue.replace(/-lt-/gi,"<").replace(/-gt-/gi,">");
					 }

					// $('namePlayer2').innerHTML = "<img src='img/flags/" + item.getElementsByTagName("flag2")[0].firstChild.nodeValue + ".png' style='border: 1px solid white'> " + item.getElementsByTagName("player2")[0].firstChild.nodeValue;


					// set the points
					for(var p=1; p<=2; p++) {
						for(var s=1; s<=<?= $maxSets ?>; s++) {

							if(s > root.getElementsByTagName("currentSet")[0].firstChild.nodeValue && root.getElementsByTagName("winnerSet3")[0].firstChild.nodeValue == 0) {
								$('set'+s+'p'+p).innerHTML = '&nbsp;';
							} else {
                                if(item.getElementsByTagName('set'+s+'p'+p)[0].firstChild.nodeValue == '-') {
                                    	$('set'+s+'p'+p).innerHTML = '&nbsp;';
                                } else {
                                        $('set'+s+'p'+p).innerHTML = item.getElementsByTagName('set'+s+'p'+p)[0].firstChild.nodeValue;
                                }
							}
							// reset every border back to gray
							$('set'+s+'p'+p).style.border = '10px solid #111';

						}

					}

					// set one green border to show how is servicing at the moment
                    if(item.getElementsByTagName('set'+item.getElementsByTagName("currentSet")[0].firstChild.nodeValue+'p1')[0].firstChild.nodeValue != '-') {
                        $('set'+item.getElementsByTagName("currentSet")[0].firstChild.nodeValue+'p'+item.getElementsByTagName("service")[0].firstChild.nodeValue).style.border = '10px solid #0f0';
                    }
					// set colored borders on finished games
                    for(var s=1; s<=<?= $maxSets ?>; s++) {
					if(item.getElementsByTagName("winnerSet"+s)[0].firstChild.nodeValue > 0) $('set'+s+'p'+item.getElementsByTagName("winnerSet"+s)[0].firstChild.nodeValue).style.border = '10px solid #f00';
                }
					//if(item.getElementsByTagName("winnerSet2")[0].firstChild.nodeValue > 0) $('set2p'+item.getElementsByTagName("winnerSet2")[0].firstChild.nodeValue).style.border = '10px solid #f00';
					//if(item.getElementsByTagName("winnerSet3")[0].firstChild.nodeValue > 0) $('set3p'+item.getElementsByTagName("winnerSet3")[0].firstChild.nodeValue).style.border = '10px solid #f00';

					// set dynamic font-size
					document.getElementsByTagName("body")[0].style.fontSize = item.getElementsByTagName("fontsize")[0].firstChild.nodeValue;

				}
			}
		}
	);

<?php } ?>

<?php if($_GET['type']=='input') { ?>
	if($('currentCourt').value) {
		new Ajax.Request("output.php?input=1&court="+$('currentCourt').value,{
				onSuccess: function(r) {
					var root = r.responseXML;
					for(var i = 0; i < root.childNodes.length; i++)
					{

						if(root.childNodes[i].nodeType != 1) continue;
						var item = root.childNodes[i];

						// controls are locked when a match finished - we need to unlock it once both players got 0 points

						if($('pl').innerText=='-' && $('pr').innerText=='-' && item.getElementsByTagName('currentSet')[0].firstChild.nodeValue == 1)
						{
						//	alert(1);
							$('inputlocked').hide();
							$('currentSet').value=1;
							$('inputSet2').style.backgroundColor = '';
							$('inputSet3').style.backgroundColor = '';
							$('inputSet1').style.backgroundColor = 'blue';
						}
						// if($('pl').innerHTML=='-' && $('pr').innerHTML=='-')
						// {
						// //	alert(1);
						// 	$('inputlocked').hide();
						// 	$('currentSet').value=1;
						// 	$('inputSet2').style.backgroundColor = '';
						// 	$('inputSet3').style.backgroundColor = '';
						// 	$('inputSet1').style.backgroundColor = 'blue';
						// }
						if(switched==0)
						 {
							if($('currentSet').value=='') { $('currentSet').value=1; }
							//alert(item.getElementsByTagName('set'+$('currentSet').value+'p1')[0].firstChild.nodeValue);
							//$('pl').innerHTML = item.getElementsByTagName('set'+item.getElementsByTagName('currentSet')[0].firstChild.nodeValue+'p1')[0].firstChild.nodeValue;
							//$('pr').innerHTML = item.getElementsByTagName('set'+item.getElementsByTagName('currentSet')[0].firstChild.nodeValue+'p2')[0].firstChild.nodeValue;
							$('pl').innerHTML = item.getElementsByTagName('set'+$('currentSet').value+'p1')[0].firstChild.nodeValue;
							$('pr').innerHTML = item.getElementsByTagName('set'+$('currentSet').value+'p2')[0].firstChild.nodeValue;
							// $('inputName1').innerHTML = item.getElementsByTagName('player1')[0].firstChild.nodeValue;
							// $('inputName2').innerHTML = item.getElementsByTagName('player2')[0].firstChild.nodeValue;

                    $('inputName2').innerHTML = getflags(item.getElementsByTagName('player2')[0].firstChild.nodeValue,item.getElementsByTagName('flag2')[0].firstChild.nodeValue,'<br>');
                    $('inputName1').innerHTML = getflags(item.getElementsByTagName('player1')[0].firstChild.nodeValue,item.getElementsByTagName('flag1')[0].firstChild.nodeValue,'<br>');
						 } else {
							$('pr').innerHTML = item.getElementsByTagName('set'+$('currentSet').value+'p1')[0].firstChild.nodeValue;
							$('pl').innerHTML = item.getElementsByTagName('set'+$('currentSet').value+'p2')[0].firstChild.nodeValue;
							// $('inputName2').innerHTML = item.getElementsByTagName('player1')[0].firstChild.nodeValue;
							// $('inputName1').innerHTML = item.getElementsByTagName('player2')[0].firstChild.nodeValue;


                            $('inputName1').innerHTML = getflags(item.getElementsByTagName('player2')[0].firstChild.nodeValue,item.getElementsByTagName('flag2')[0].firstChild.nodeValue,'<br>');
                            $('inputName2').innerHTML = getflags(item.getElementsByTagName('player1')[0].firstChild.nodeValue,item.getElementsByTagName('flag1')[0].firstChild.nodeValue,'<br>');

						 }
	//					alert(item.getElementsByTagName('player1')[0].firstChild.nodeValue);
						//=
						$('background').innerHTML = "court "+$('currentCourt').value;

						// set one green border to show how is servicing at the moment
						$('inputName1').style.border = '0px';
						$('inputName2').style.border = '0px';
						 if(switched==0)
						 {
							$('inputName'+item.getElementsByTagName("service")[0].firstChild.nodeValue).style.border = '5px solid #0f0';
						 } else {
							serve = item.getElementsByTagName("service")[0].firstChild.nodeValue;

							if(serve==1) {$('inputName2').style.border = '5px solid #0f0';}
							if(serve==2) {$('inputName1').style.border = '5px solid #0f0';}


						 }


						 // when a set is over - show a dialog box

						if(item.getElementsByTagName('winnerSet'+$('currentSet').value)[0].firstChild.nodeValue>0 && dialogShown==false) {
// && $('currentSet').value == item.getElementsByTagName('currentSet')[0].firstChild.nodeValue
// console.log(item.getElementsByTagName('currentSet')[0].firstChild.nodeValue);
// console.log($('currentSet').value)
							// if(item.getElementsByTagName('winnerSet1')[0].firstChild.nodeValue==item.getElementsByTagName('winnerSet2')[0].firstChild.nodeValue)
							// {
							// 	if($('currentSet').value==1) { confirmtext='1st set finished, switch to 2nd set?'; }
							// 	if($('currentSet').value==2) { confirmtext='2nd set finished, switch to next match?'; }
							// } else {
							// 	if($('currentSet').value==1) { confirmtext='1st set finished, switch to 2nd set?'; }
							// 	if($('currentSet').value==2) { confirmtext='2nd set finished, switch to 3rd set?'; }
							// 	if($('currentSet').value==3) { confirmtext='3rd set finished, switch to next match?'; }
							// }
                            var winsP1 = 0
                            var winsP2 = 0
                            for(var s=1; s<=<?= $maxSets ?>; s++) {
                                // console.log('set ' + s + ' won by ' + item.getElementsByTagName('winnerSet'+s)[0].firstChild.nodeValue)
                                if(item.getElementsByTagName('winnerSet'+s)[0].firstChild.nodeValue == 1) { winsP1=winsP1+1 }
                                if(item.getElementsByTagName('winnerSet'+s)[0].firstChild.nodeValue == 2) { winsP2=winsP2+1 }
                            }
                            // console.log(winsP1);
                            // console.log(winsP2);
                            if($('currentSet').value == <?= $maxSets ?> || winsP1*2 > <?= $maxSets ?> || winsP2*2 > <?= $maxSets ?>) {
                                confirmtext='switch to next match?';
                            } else {
                                confirmtext='switch to next game?';
                            }
							if(confirm(confirmtext)) { //yes
								if($('currentSet').value==<?= $maxSets ?> || winsP1*2 > <?= $maxSets ?> || winsP2*2 > <?= $maxSets ?>)
								{
									$('currentSet').value = 1;
									$('inputSet1').style.backgroundColor = 'blue';
									$('inputSet3').style.backgroundColor = '';
									dialogShown=true;
									$('inputlocked').show();
								} else {
                                    $('inputSet'+$('currentSet').value).style.backgroundColor = '';
                                    $('currentSet').value = parseInt($('currentSet').value)+1;
                                    $('inputSet'+$('currentSet').value).style.backgroundColor = 'blue';
                                }

							} else {
								dialogShown = true;
							}
						}

						if(item.getElementsByTagName('winnerSet'+$('currentSet').value)[0].firstChild.nodeValue==0) { dialogShown=false; }
					}
				}
			}
		);
	}
<?php } ?>

<?php if($_GET['type']=='control') { ?>
	new Ajax.Request("monitors.php",{
			onSuccess: function(r) {

				$('allmonitors').innerHTML = r.responseText;

			}
		}
	);
<?php } ?>


}, <?php echo $updateInterval; ?>);


</script>
<body>
<div id='main' style=''>
<center>
<?php if($_GET['skipmain']) { ?>
	<a href="?"><input id='mainB' class='button' type="button" value="main menu" style="width: 20%; height: 10%; font-size: 200%"></a>
<?php } ?>

<?php
if(!$_GET['type']) {
    include('sub/default.php');
}

if($_GET['type']=='input') {
    include('sub/input.php');
}

if($_GET['type']=='players') {
    include('sub/players.php');
}

if($_GET['type']=='teams') {
    include('sub/teams.php');
}

if($_GET['type']=='output') {
    include('sub/output.php');
}

if($_GET['type']=='control') {
	?>

		these are the monitors
		<div id="allmonitors">

		</div>
	<?php
} ?>


</center>

<div id="background" style='bottom: -10px; right: 10px; color: #333; font-weight: bold; z-index: -1; position: absolute;  font-size: 10em'></div>
</div>
</body>
</html>

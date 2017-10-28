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
?>
	<a href="?type=input"><input class='button' type="button" value="input" style="width: 20%; height: 30%; font-size: 200%"></a>
	<a href="?type=output"><input class='button' type="button" value="output" style="width: 20%; height: 30%; font-size: 200%"></a>
	<a href="?type=control"><input class='button' type="button" value="control" style="width: 20%; height: 30%; font-size: 200%"></a>
	<a href="?type=players"><input class='button' type="button" value="edit players" style="width: 20%; height: 30%; font-size: 200%"></a>
	<br><br><br><br><?php
	for($i=1;$i<$courts+1;$i++) {
	?>
		<a href="?type=input&c=<?php echo $i; ?>"><input class='button' type="button" value="<?php echo $i; ?>" style="width: 5%; height: 10%; font-size: 200%"></a>
	<?php } ?><br><br><br><br>
	<a href="dual.html"><input class='button' type="button" value="dual view" style="width: 15%; height: 30%; font-size: 200%"></a>
	<a href="d.apk"><input class='button' type="button" value="dolphin download" style="width: 15%; height: 30%; font-size: 200%"></a>
	<a href="info-draw"><input class='button' type="button" value="info view" style="width: 15%; height: 30%; font-size: 200%"></a>
	<a href="info-game-number"><input class='button' type="button" value="match number" style="width: 15%; height: 30%; font-size: 200%"></a>
	<a href="overview.php"><input class='button' type="button" value="overview" style="width: 15%; height: 30%; font-size: 200%"></a>
	<a href="overview-courts.php"><input class='button' type="button" value="all courts" style="width: 15%; height: 30%; font-size: 200%"></a>
<?php } ?>

<?php
if($_GET['type']=='input') {
	if(!$_GET['c'])
	{
		echo '<input type="button" onclick="window.location.reload();" style="width:90%; height: 10%; font-size: 5em" value="Reload">';
	}
	if($_COOKIE['currentCourt'] && $_GET['c']=='x') {
		$_GET['c'] = $_COOKIE['currentCourt'];
		?>
		<div style="position:absolute; left: 45%; right: 45%;"><input type="button" value="" style=" border: 0px; background:#222;" onclick="location.href='setcookie.php?currentCourt=x'"></div>
		<?php
	}
	if($_GET['c']=='x') {
		?>
			<div style="background: #ff0000; position: absolute; width: 100%; height: 100%">
				<?php
				for($i=1;$i<=$courts;$i++) {
					?><a href="setcookie.php?currentCourt=<?php echo $i; ?>"><input  class='button' type="button" value="<?php echo $i; ?>" style="width: 25%; height: 30%;"></a><?php
				}
				?>
			</div>
		<?php
	}
	?>

	<div id="inputlocked" style="opacity: 0.9; display: none; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background: black; z-index: 3;">
		<table summary=""  width="100%" height="100%">
			<td width="100%" height="100%" align="center" style='font-size: 2em'>this match is finished<br><br><br>match control will place a new match on this court soon</td>
		</table>
	</div>

	<div id="settings" style="display: none; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background: black; z-index: 3">
	<table style='height: 100%'>
		<tr>
			<td class="settingslabel">match:</td>
			<td>
				<select id='selectMatch' name='selectMatch' onchange="pushButton(this,false)"></select>&nbsp;<img src='img/loading.gif' id='matchloading'>
			</td>
		</tr>
		<tr>
			<td class="settingslabel">event:</td><td>
				<?php $events = scandir('players');
				foreach($events as $event)
				{
					if($event == '.' || $event == '..' || strpos($event,'~') != 0 || strpos($event,'_') != 0) continue;
					$event = str_replace(".txt","",$event);
					?>
					<input type="button" value='<?php echo $event; ?>' name='event' style="width: 3.5em; height: 1.5em; font-size: 200%" onclick="pushButton(this,false)">
					<?php
				}
				?>
			</td><td><img src="img/symbol_check.png" id='eventCheck' style="height:32px; width:32px; display: none"></td>
		</tr>
		<tr>
			<td class="settingslabel">court:</td><td>
				<?php
				for($i=1;$i<$courts+1;$i++)
				{

					$changetime = @filemtime("sessions/courts/".$i);


					?>
					<input type="button" value='<?php echo $i; ?>' name='court' style="width: 3em; height: 1.5em; font-size: 200%; <?php if((time()-$changetime)<120) { echo 'color: white;'; } ?>" onclick="pushButton(this,false)">
					<?php
				}
				?>
			</td><td><img src="img/symbol_check.png" id='courtCheck' style="height:32px; width:32px; display: none"></td>
		</tr>
		<tr id='player1' style='display: none'>
			<td class="settingslabel"></td><td>
				<select id='selectNation1' name='selectNation1' onchange="pushButton(this,false)"></select>
				<select id='selectPlayer1' name='selectPlayer1' onchange="pushButton(this,false)"></select>
			</td><td><img src="img/symbol_check.png" id='playerCheck1' style="height:32px; width:32px; display: none"></td>
		</tr>
		<tr id='player2' style='display: none'>
			<td class="settingslabel">players:</td><td align="right">
				<select id='selectPlayer2' name='selectPlayer2' onchange="pushButton(this,false)"></select>
				<select id='selectNation2' name='selectNation2' onchange="pushButton(this,false)" <?php if($sameNationTrigger) { echo "style='display: none'"; } ?>></select>
			</td><td><img src="img/symbol_check.png" id='playerCheck2' style="height:32px; width:32px; display: none"></td>
		</tr>
		<tr>
			<td colspan='3' align='center'>
				<input type="button" name='closeSettings' id='closeSettings' value='close' style="display:none; width: 40%; height: 1.5em; font-size: 200%" onclick="pushButton(this,false)">
			</td>
		</tr>
		<tr><td></td><td class="settingslabel" id='settingsinfo'>please select event, court and players</td></tr>
	</table>

	</div>
	<table id='input' style='height: 90%;'>
	 <?php if($_GET['c']==12) { ?>
		<tr style='<?php if(!$_GET['c']) {echo "display:none;"; } ?>' id='inputButtons'>
			<td id='kl'>
				<input class='button' type="button" value="+" name="pointP1" id="pb1" style="width: 55%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="-" name="pointP1" id="pb2" style="width: 35%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="+" name="pointP2" id="pb3" style="display: none; width: 55%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="-" name="pointP2" id="pb4" style="display: none; width: 35%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
			</td>
			<td id="km" style="">
				Set:<br>

				<input class='button' type="button" value="1" id='inputSet1' name='set' style=" height: 2em; font-size: 150%"  onclick="pushButton(this,false)">
				<input class='button' type="button" value="2" id='inputSet2' name='set' style=" height: 2em; font-size: 150%"  onclick="pushButton(this,false)">
				<input class='button' type="button" value="3" id='inputSet3' name='set' style=" height: 2em; font-size: 150%"  onclick="pushButton(this,false)">
			</td>
			<td id='kr'>
				<input class='button' type="button" value="-" name="pointP2" id="pb6" style="width: 35%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="+" name="pointP2" id="pb5" style="width: 55%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="-" name="pointP1" id="pb8" style="display: none; width: 35%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="+" name="pointP1" id="pb7" style="display: none; width: 55%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">

			</td>
		</tr>
	 <?php } ?>
		<tr>
			<td id='pl'>-</td>
			<td id="pm" style="">:</td>
			<td id='pr'>-</td>
		</tr>
		<tr>
			<td id="inputName1" style='font-weight: bold'></td>
			<td>
				<input class='button' type="button" value="change ends" id='switchButton' style=" height: 2em; font-size: 150%"  onclick="pushButton(this,true)"><br><br>
				<input class='button' type="button" value="settings" id='settingsButton' style="<?php if($_GET['c']) {echo "display:none;"; } ?> width: 50%; height: 2em; font-size: 150%"  onclick="pushButton(this,true);">
			</td>
			<td id="inputName2" style='font-weight: bold'></td>
		</tr> <?php if($_GET['c']!=12) { ?>
		<tr style='<?php if(!$_GET['c']) {echo "display:none;"; } ?>' id='inputButtons'>
			<td id='kl'>
				<input class='button' type="button" value="+" name="pointP1" id="pb1" style="width: 55%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="-" name="pointP1" id="pb2" style="width: 35%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="+" name="pointP2" id="pb3" style="display: none; width: 55%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="-" name="pointP2" id="pb4" style="display: none; width: 35%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
			</td>
			<td id="km" style="">
				Set:<br>
				<?php for($set=1;$set<=$maxSets;$set++) { ?>
				<input class='button' type="button" value="<?= $set ?>" id='inputSet<?= $set ?>' name='set' style=" height: 2em; font-size: 150%"  onclick="pushButton(this,false)">
				<?php } ?>
			</td>
			<td id='kr'>
				<input class='button' type="button" value="-" name="pointP2" id="pb6" style="width: 35%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="+" name="pointP2" id="pb5" style="width: 55%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="-" name="pointP1" id="pb8" style="display: none; width: 35%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">
				<input class='button' type="button" value="+" name="pointP1" id="pb7" style="display: none; width: 55%; height: 4em; font-size: 200%" onclick="pushButton(this,true)">

			</td>
		</tr>	 <?php } ?>
		<tr style="display: none">
			<td colspan='3' style='color: gray'>
				Court: <input id='currentCourt' type='text' value='<?php echo $_GET['c']; ?>' style='width: 4%'> - Event: <input id='currentEvent' type='text' value='' style='width: 4%'> - Players: <input id='currentPlayers' type='text' value=''> - Set: <input id='currentSet' type='text' value='' style='width: 4%'>
			</td>
		</tr>
	</table>
<?php } ?>

<?php
if($_GET['type']=='players') {

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
<?php } ?>

<?php
if($_GET['type']=='output') {
	?>
	<div id="sponsoren" style="display: none; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background: black; z-index: 3">
		<script type="text/javascript" src="js/crossfade.js"></script>
		<ul id="gallery" style='list-style-type:none; margin: 300px auto;'>
		<?php
		$fotos = scandir('img/sponsors/');

		foreach($fotos as $foto)
		{
			if(substr($foto,0,1) == '.' || $foto == '..' ) continue;
			?><li style='align: center;'><img src='img/spacer.gif' style="width:700px"></li><?php
			if($_GET['style']==2) {
				?><li style='align: center;'><img src='img/sponsors/<?php echo $foto; ?>' style="width:700px"></li><?php
			} else {
				?><li style='align: center;'><img src='img/sponsors/<?php echo $foto; ?>' style="width:700px"></li><?php
			}
		}
		?>
		</ul>
	</div>



	<div id="images" style="display: none; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background: black; z-index: 3;">
	photos
	</div>

	<div id="misc" style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background: url('img/background.jpg'); z-index: 3; background-size: 100%  auto;"><div style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; background: rgba(0,0,0,0.3); ">
		<table style='height:100%'>
			<td>
				<!--<img src='img/astrop_black.png'>-->
				<div style="background: rgba(0,0,0, 0.5); border-radius: 20px; padding: 50px; ">
				<span style="font-size: 4em;" nowrap>Unconnected&nbsp;Display</span>
					</div>
				<span style="display: show; font-size: 6em; position: absolute; right: -10px; bottom: 10px; background: rgba(0,0,0, 0.5); border-radius: 20px; padding: 20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php $ips = explode(".",$_SERVER['REMOTE_ADDR']);	echo $deviceid; ?></span>
			</td>
		</table>
			</div>
	</div>
	<table summary="" id="output">
		<tr id="tblNames1">
			<td colspan="<?= $maxSets ?>" id="namePlayer1">&nbsp;</td>
		</tr>
		<tr id="tblScore1">
			<?php for($set=1;$set<=$maxSets;$set++) { ?>
			<td class='scoreboard' id='set<?= $set ?>p1'>-</td>
			<?php } ?>
		</tr>
		<tr id="tblScore2">
			<?php for($set=1;$set<=$maxSets;$set++) { ?>
			<td class='scoreboard' id='set<?= $set ?>p2'>-</td>
			<?php } ?>
		</tr>
		<tr id="tblNames2">
			<td colspan="<?= $maxSets ?>" id="namePlayer2">&nbsp;</td>
		</tr>
	</table>
	<span style="font-size: 5em; position: absolute; right: 10px; bottom: 10px; opacity:0.02"><?php
		if($ips[3]!=69) {
			echo $deviceid;
		} else {
			echo '<div style="border: 1px solid yellow; border-radius: 10px; padding: 2px; color: yellow">'.$_GET['debugid'].'</div>';
		}
		?></span>

<?php } ?>

<?php
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

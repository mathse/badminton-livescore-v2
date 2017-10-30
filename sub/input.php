<?php
if(!$_GET['c'])
{
    echo '<input type="button" onclick="window.location.reload();" style="width:90%; height: 10%; font-size: 5em" value="Reload">';
}
echo '<title>Court Input '.$_GET['c'].'</title>';
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

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
    ?>
</span>

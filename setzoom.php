<?php
if(@$_GET['zoom'] && @$_GET['type']) {
    $fd = fopen('sessions/zoom_'.$_GET['type'],'w');
    if ($_GET['zoom']=="NaN") $_GET['zoom'] = 0;
    fwrite($fd,$_GET['zoom']);
    fclose($fd);
}
?>
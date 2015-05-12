<?php
function sendToMeteorDB($collection,$object,$data) {
    echo $collection." ".$object." ".$data;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "http://localhost:3000/collectionapi/".$collection."/".$object);
    curl_setopt($ch,CURLOPT_HTTPHEADER, array('X-Auth-Token: 97f0ad9e24ca5e0408a269748d7fe0a0'));
    curl_setopt($ch,CURLOPT_POST, True);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, True);
    curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
#    $r = curl_exec($ch);
    echo $r;
    if(trim($r) == '{"message":"No Record(s) Found"}') {
        curl_setopt($ch,CURLOPT_URL, "http://localhost:3000/collectionapi/".$collection);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array('X-Auth-Token: 97f0ad9e24ca5e0408a269748d7fe0a0'));
        curl_setopt($ch,CURLOPT_POST, True);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, False);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POSTFIELDS, '{"_id":"'.$object.'", '.substr($data,1,-1).'}');
#        curl_exec($ch);
    }
    curl_close($ch);
}
if(@$_GET['bgtime']!="") {
    sendToMeteorDB('control', 'BackgroundTime', $_GET['bgtime']);
}

if(@$_GET['colorForDevice']!="") {
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, "http://localhost:3000/collectionapi/connections/".$_GET['colorForDevice']);
    curl_setopt($ch,CURLOPT_HTTPHEADER, array('X-Auth-Token: 97f0ad9e24ca5e0408a269748d7fe0a0'));
    curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
#    $t=json_decode(curl_exec($ch)); echo $t[0]->color;
    curl_close($ch);
}

if(@$_GET['showAds']!="") {
#    sendToMeteorDB('control', 'showAds', $_GET['showAds']);
}

if(@$_GET['textToShow']) {
#    sendToMeteorDB('control', 'textToShow', urldecode($_GET['textToShow']));
}
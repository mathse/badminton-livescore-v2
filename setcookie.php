<meta http-equiv="refresh" content="0; url=/badminton-livescore-v2/?type=input&c=x">
<?php
if($_GET['currentCourt']) {
    setcookie("currentCourt",$_GET['currentCourt'],time()+(3600*24*5));
}
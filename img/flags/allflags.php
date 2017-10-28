<?php
$f = scandir('./');
foreach ($f as $i) {
    ?><img src='<?php echo $i; ?>' style="height: 100px"><br><?php
}
?>

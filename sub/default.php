
<a href="?type=input"><input class='button' type="button" value="input" style="width: 15%; height: 20%; font-size: 200%"></a>
<a href="?type=output"><input class='button' type="button" value="output" style="width: 15%; height: 20%; font-size: 200%"></a>
<a href="?type=control"><input class='button' type="button" value="control" style="width: 15%; height: 20%; font-size: 200%"></a>
<a href="?type=players"><input class='button' type="button" value="edit players" style="width: 15%; height: 20%; font-size: 200%"></a>
<a href="?type=teams"><input class='button' type="button" value="edit teams" style="width: 15%; height: 20%; font-size: 200%"></a>
<br><br><br><br><?php
for($i=1;$i<$courts+1;$i++) {
    ?>
    <a href="?type=input&c=<?php echo $i; ?>"><input class='button' type="button" value="<?php echo $i; ?>" style="width: 5%; height: 10%; font-size: 200%"></a>
    <?php
} ?><br><br><br><br>
<a href="dual.html"><input class='button' type="button" value="dual view" style="width: 15%; height: 30%; font-size: 200%"></a>
<a href="d.apk"><input class='button' type="button" value="dolphin download" style="width: 15%; height: 30%; font-size: 200%"></a>
<a href="info-draw"><input class='button' type="button" value="info view" style="width: 15%; height: 30%; font-size: 200%"></a>
<a href="info-game-number"><input class='button' type="button" value="match number" style="width: 15%; height: 30%; font-size: 200%"></a>
<a href="overview.php"><input class='button' type="button" value="overview" style="width: 15%; height: 30%; font-size: 200%"></a>
<a href="overview-courts.php"><input class='button' type="button" value="all courts" style="width: 15%; height: 30%; font-size: 200%"></a>

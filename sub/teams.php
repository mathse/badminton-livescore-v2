<style type="text/css">
textarea {
    font-size: 2em;
    background: #222;
    border: 0px;
    margin: 2px;
    padding: 10px;
    overflow:hidden
}
.firstrow {
    font-size: 2em;
    vertical-align: top;
    align: right;
    padding-top: 13px
}
.name {
    background: #222;
    border: 0px;
    padding-left: 10px;
    font-size: 2em;
}
</style>

<?php
if($_POST['name-gast']) {

    $fd = fopen('./players/aufstellung.txt','w+');
    $content = json_encode(array("gast" => htmlentities($_POST['name-gast']),
                        "aufstellung-heim" => htmlentities($_POST['aufstellung-heim']),
                        "aufstellung-gast" => htmlentities($_POST['aufstellung-gast'])));
                        // echo $content;
    if(fwrite($fd, $content)) {
        echo "speichern erfolgreich";
    } else {
        echo "speichern fehlgeschlagen";
    }
    fclose($fd);
}

$lineup = json_decode(@file_get_contents('./players/aufstellung.txt'));

?>

<form method="post" action="index.php?type=teams">
<table>
    <th></th>
    <th><input type="text" name="name-heim" class="name" value="SG EBT Berlin"></th>
    <th><input type="text" name="name-gast" class="name" value="<?php echo $lineup->gast; ?>"></th>
    <tr>
        <td class="firstrow">
            1. HD<br>DD<br>2. HD<br>DE<br>MX<br>1. HE<br>2. HE<br>3. HE
        </td>
        <td>
            <textarea rows="8" name="aufstellung-heim"><?php echo $lineup->{'aufstellung-heim'}; ?></textarea>
        </td>
        <td>
            <textarea rows="8" name="aufstellung-gast"><?php echo $lineup->{'aufstellung-gast'}; ?></textarea>
        </td>
    </tr>
</table>
<input type="submit" value="Aufstellungen Speichern">
</form>

<html>
<style type="text/css">
    * { background-color: black}
    .image
    {
        position:relative;
    }

    .image img
    {
        position:absolute;
        top:0;
        left:0;
    }

</style>
<script type="text/javascript" src="../../js/jquery-2.1.1.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/jquery.periodic.js"></script>
<script type="text/javascript" src="../../js/jquery.ui.touch-punch.min.js"></script>
<script>

    $( document ).ready(function() {
        console.log("ready");
        $('.image img:gt(0)').hide();
        setInterval(function()
        {
            console.log("asd");
            $('.image :first-child').fadeOut(1000).next().fadeIn(1000).end().appendTo('.image');
        },5000);
    });

</script>
<body>
<div >
    <table style="width: 100%; height: 100%"><td valign="middle" align="center" class="image">
            <?php
            foreach(scandir("../../img/sponsors") as $image) {
                if(substr($image,0,1) == '.' ) continue;
                echo '<img src="../../img/sponsors/'.$image.'">';
            }

            ?>
        </td></table>
</div>
</body>
</html>

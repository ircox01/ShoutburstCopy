<?php
if (isset($_GET['rec_id'])) {
	$rec_id = $_GET['rec_id'];
}

?>
<script type="text/javascript" src="jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="CvAtSHkcmFQjxxbZw6S+xh0ykG5VNZLnmZIggA==";</script>

<div id="myElement" >Loading the player...</div>

<script type="text/javascript">
    jwplayer("myElement").setup({
        file: "recordings/<?=$rec_id?>",
	width: 80,
	height: 25,
	autostart: true
    });
</script>

<?php
session_start();
/*Don’t use the regeneration function, it will do it by itself*/
//session_regenerate_id();
echo "<b>Session ID: </b>";
echo session_id();
echo "</p><a href=\"index.php\">Link</a>";
?>

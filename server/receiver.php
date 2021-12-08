<?php
echo "<h1>Hello!</h1>";
echo "The direct send service has been phased out, however, you have triggered a data refresh from the git repository<br />";
include("git.php");
file_put_contents("lastContact",time());

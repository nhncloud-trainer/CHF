<?php
if ($_GET['start']) {
    $cmd = "stress -c 2 -t 300 > /dev/null 2>&1 &";
    exec($cmd);
} else if ($_GET['stop']) {
    $cmd = "pkill -f stress";
    exec($cmd);
}
?>


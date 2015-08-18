<?php
    $ip = getenv('DYLD_LIBRARY_PATH');
    echo $ip;
exec ("export DYLD_LIBRARY_PATH=123");
    echo "<br>";
    echo "<br>";
    echo "<br>";
    $ip1 = getenv('DYLD_LIBRARY_PATH');
    echo $ip1;

?>
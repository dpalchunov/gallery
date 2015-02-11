<?php

require_once 'phplibs/ResourceService.php';

session_start();
if ( isset($_SESSION['state'])) {
    $viewer = new AboutEditPageViewer();
    $viewer -> show($_POST);
} else {
    echo 'page not found';
}


?>
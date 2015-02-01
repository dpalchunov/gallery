<?php   
  require_once 'phplibs/ResourceService.php';
    if ($_COOKIE['greetingWasShown'] == 'true') {
        $page = new AboutPageViewer();
    } else {
        $page = new GreetingPageViewer();
    }
$page -> show($_POST);
?>
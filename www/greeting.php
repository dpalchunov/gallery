<?php   
  require_once 'phplibs/ResourceService.php';
  $aboutPage = new GreetingPageViewer();
  $aboutPage -> show($_POST);
?>
<?php   
  require_once 'phplibs/ResourceService.php';
  $aboutPage = new AboutPageViewer();
  $aboutPage -> show($_POST);
?>
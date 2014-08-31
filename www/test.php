<?php   
  require_once 'phplibs/ResourceService.php';
  $resourceService = new ResourceService();
  $resourceService -> getLang(); 
  $resourceService -> changeLang();  
?>
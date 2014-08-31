<?php
  require_once 'phplibs/ResourceService.php';
  $resourceService = new ResourceService();  
  $lang = $resourceService -> getLang();   
  $picturesGetter = new PicturesGetter($lang);
  $filter = $_POST;
  echo $picturesGetter->getPicturesCountByFilter($filter);
?>

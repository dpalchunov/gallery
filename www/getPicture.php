<?php
  require_once 'phplibs/ResourceService.php';
  $resourceService = new ResourceService();  
  $lang = $resourceService -> getLang();   
  $picturesGetter = new PicturesGetter($lang);
  $num = $_POST['picNum'];
  $filter = $_POST;
  unset($filter['picNum']);
  echo $picturesGetter->getFullScreenGalleryPicture($filter,$num);
?>

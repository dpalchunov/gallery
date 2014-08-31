<?php
  require_once 'phplibs/ResourceService.php';
  $picturesGetter = new PicturesGetter();
  $num = $_GET['picNum'];
  $filter = $_GET;
  unset($filter['picNum']);
  echo $picturesGetter->getFullScreenGalleryPicture($filter,$num);
?>

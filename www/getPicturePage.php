<?php
  require_once 'phplibs/ResourceService.php';
  $resourceService = new ResourceService();
  $lang = $resourceService -> getLang();  
  $picturesGetter = new PicturesGetter($lang);
  $pageNum = $_POST['pageNum'];
  $filter = $_POST;
  unset($filter['pageNum']);
  unset($filter['lang']); 
  echo $picturesGetter->getPicturesPageByFilterAndPageNum($filter,$pageNum,$lang);
?>

<?php
  require_once 'phplibs/ResourceService.php';
  $picturesGetter = new PicturesGetter();
  $pageNum = $_POST['pageNum'];
  $filter = $_POST;
  unset($filter['pageNum']);
  echo $picturesGetter->getPicturesPageByFilterAndPageNum($filter,$pageNum);
?>

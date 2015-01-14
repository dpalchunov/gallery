<?php

  require_once 'phplibs/ResourceService.php';
  $galleryViewer = new GalleryViewer();
  if (isset($_POST['header'])) {
      $galleryViewer -> showHead();
  } else if (isset($_POST['body'])) {
      $galleryViewer -> showBody();
  } else {
      $galleryViewer -> showPage();
  }
?>
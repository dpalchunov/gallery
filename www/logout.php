<?php
  require_once 'phplibs/ResourceService.php';
  session_start();
  session_unset();
  header("Location:about.php");
  die();
?>
<?php
  require_once 'phplibs/ResourceService.php';
  if (isset($_POST['n_v']) and isset($_POST['p_v'])) {
    if (true) {
        session_start();
        $_SESSION['state'] = 'ok';
        header('location:home.php');
        die();
        $page = new HomePageViewer();
    } else {
        $page = new LoginPageViewer();
    }
  } else {
      if (isset($_SESSION['state'])) {
          session_unset();
      }
      $page = new LoginPageViewer();
  }
  $page -> show($_POST);
?>
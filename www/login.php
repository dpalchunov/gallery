<?php
  require_once 'phplibs/ResourceService.php';
  if (isset($_POST['n_v']) and isset($_POST['p_v'])) {
    if (md5($_POST['n_v'].$_POST['p_v']) == '3e6e2489ed0c491c5bedf4579b13de2a') {
        session_start();
        $_SESSION['state'] = 'ok';
        header('location:about.php');
        die();
        $page = new AboutPageViewer();
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
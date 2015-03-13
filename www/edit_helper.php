<?php

require_once 'phplibs/ResourceService.php';

session_start();
if ( isset($_SESSION['state'])) {
    if ( isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'del_file') {
            $res =unlink($_POST['src']);
            echo json_encode($res);
        }   else if ($action == '') {



        }   else if ($action == '') {

        }
           else if ($action == '') {

        }   else if ($action == '') {


            }
    } else {
        $viewer = new AboutEditPageViewer();
        $viewer -> show($_POST);
    }
}
else {
    echo 'page not found';
}

?>
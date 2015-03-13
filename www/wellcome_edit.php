<?php

require_once 'phplibs/ResourceService.php';

$output_dir = "uploads/intros_tmp/";

session_start();
if ( isset($_SESSION['state'])) {
    if ( isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($post['action'] == 'get_avas_array') {
            $persistedPicsGetter = new PersistedIntrosGetter();
            $jsArrayHtml = $persistedPicsGetter->getPicsArray();
            $result = json_encode($jsArrayHtml);
            echo $result;
        } else if ($action == 'get_intros') {
            $persistedPicsGetter = new PersistedIntrosGetter();
            $persisted_avas_html_code = $persistedPicsGetter->generatePicsHtmlForEdit();
            echo $persisted_avas_html_code;
        }   else if ($action == 'edit_save_intro') {
            $crop = new IntroCropper($_POST['avatar_src'], $_POST['avatar_data']);
            $response = array(
                'state' => 200,
                'message' => $crop->getMsg(),
                'result' => $crop->getResult()
            );

            echo json_encode($response);

        }   else if ($action == 'edit_upload_ava') {

            if(isset($_FILES["myfile"]))
            {

                require_once 'phplibs/FileLoader.php';
                $fileLoader = new FileLoader();
                $files =  $_FILES["myfile"];
                $files["persist_name"] = "tmp";
                $ret = $fileLoader -> uploadFiles($files,$output_dir);
                $size = getimagesize($ret[0]);
                $w = $size[0];
                $height = $size[1];
                $ret[1] = $w;
                $ret[2] = $height;
                echo json_encode($ret);

            }

        }
    } else {
        $viewer = new WellcomeEditPageViewer();
        $viewer -> show($_POST);
    }
} else {
    echo 'page not found';
}


?>
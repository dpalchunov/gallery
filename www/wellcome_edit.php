<?php

require_once 'phplibs/ResourceService.php';
require_once './helpers.php';
require_once './helpers.php';
actionHeader();

$actions = array(
    "get_avas_array" => array ("type" => "everyone"),
    "get_intros" => array ("type" => "everyone"),
    "edit_save_intro" => array ("type" => "super_role"),
    "edit_upload_ava" => array ("type" => "super_role")
);

function common_action_handler() {
    $viewer = new WellcomeEditPageViewer();
    $viewer -> show($_POST);
}
function get_avas_array_handler() {
    $persistedPicsGetter = new PersistedIntrosGetter();
    $jsArrayHtml = $persistedPicsGetter->getPicsArray();
    $result = json_encode($jsArrayHtml);
    echo $result;
}

function get_intros_handler() {
    $persistedPicsGetter = new PersistedIntrosGetter();
    $persisted_avas_html_code = $persistedPicsGetter->generatePicsHtmlForEdit();
    echo $persisted_avas_html_code;
}

function edit_save_intro_handler() {
    $crop = new IntroCropper($_POST['avatar_src'], $_POST['avatar_data']);
    $response = array(
        'state' => 200,
        'message' => $crop->getMsg(),
        'result' => $crop->getResult()
    );

    echo json_encode($response);
}

function edit_upload_ava_handler() {
    if(isset($_FILES["myfile"]))
    {
        $output_dir = "uploads/intros_tmp/";
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






require_once './router.php';
?>
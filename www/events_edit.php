<?php



require_once 'phplibs/ResourceService.php';
require_once './helpers.php';
actionHeader();

$actions = array(
    "common_action" => array ("type" => "super_role"),
    "first_ava" => array ("type" => "super_role"),
    "get_avas_array" => array ("type" => "everyone"),
    "get_avas_html" => array ("type" => "everyone"),
    "save_img" => array ("type" => "everyone"),
    "upload_img" => array ("type" => "everyone")
);

function common_action_handler() {
    $viewer = new AboutEditPageViewer();
    $viewer -> show($_POST);
}

function first_ava_handler() {
    if (isset($_POST['avatar_src'])) {
        $type = exif_imagetype($_POST['avatar_src']);

        if ($type) {
            $extension = image_type_to_extension($type);
            $dir = 'images/slider/avas';
            if (!file_exists($dir)) {
                mkdir($dir, 0777);
            }
            $dst = $dir . '/' . date('YmdHis').getmicrotime(). $extension;
            $name = $_POST['avatar_src'];
            $res = rename($name,$dst);
            echo json_encode($res);
        }
    }
}
function get_avas_array_handler() {
    $persistedAvasGetter = new PersistedAvasGetter();
    $jsArrayHtml = $persistedAvasGetter->getPicsArray();
    $result = json_encode($jsArrayHtml);
    echo $result;
}
function get_avas_html_handler() {
    $persistedAvasGetter = new PersistedAvasGetter();
    $persisted_avas_html_code = $persistedAvasGetter->generatePicsHtmlForEdit();
    echo $persisted_avas_html_code;
}
function upload_img_handler() {
    if(isset($_FILES["myfile"])) {
        $output_dir = "uploads/events_tmp/";
        require_once 'phplibs/FileLoader.php';
        $fileLoader = new FileLoader();
        $files =  $_FILES["myfile"];
        $files["persist_name"] = "tmp";
        $ret = $fileLoader -> uploadFiles($files,$output_dir);
        $size = getimagesize($ret[0]);

        $ret = array("size" => $size,
                     "url" => $output_dir.$files["persist_name"]);
        echo json_encode($ret);
    }
}
function save_img_handler() {
    $crop = new EventsPicCropper($_POST['url'], $_POST['crop']);
    $res = $crop->crop();


    echo json_encode($res);
}

require_once './router.php';
?>
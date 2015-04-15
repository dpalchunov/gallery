<?php



require_once 'phplibs/ResourceService.php';
require_once './helpers.php';
actionHeader();

$actions = array(
    "common_action" => array ("type" => "super_role"),
    "first_ava" => array ("type" => "super_role"),
    "get_avas_array" => array ("type" => "everyone"),
    "get_avas_html" => array ("type" => "everyone"),
    "save_ava" => array ("type" => "super_role"),
    "upload_ava" => array ("type" => "super_role")
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
function save_ava_handler() {
    $crop = new AvatarCropper($_POST['avatar_src'], $_POST['avatar_data']);
    $response = array(
        'state' => 200,
        'message' => $crop->getMsg(),
        'result' => $crop->getResult()
    );

    echo json_encode($response);
}
function upload_ava_handler() {
    if(isset($_FILES["myfile"])) {
        $output_dir = "uploads/ava_tmp/";
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
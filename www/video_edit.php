<?php

require_once 'phplibs/ResourceService.php';
require_once './helpers.php';
actionHeader();

$actions = array(
    "edit_upload_vid" => array ("type" => "super_role"),
    "edit_update_vid" => array ("type" => "super_role"),
    "edit_del_vid" => array ("type" => "super_role"),
    "edit_save_vid" => array ("type" => "super_role"),
    "expo_save" => array ("type" => "super_role"),
    "edit_get_gallery" => array ("type" => "everyone"),
    "edit_get_page_count" => array ("type" => "everyone"),
    "edit_get_pagination" => array ("type" => "everyone")
);

function common_action_handler() {
    $viewer = new VideoEditPageViewer();
    $viewer -> show($_POST);
}


function edit_upload_vid_handler() {
    if(isset($_FILES["myfile"]))
    {
        require_once 'phplibs/FileLoader.php';
        $output_dir = "uploads/vid_tmp/";
        $thumb_tmp_name = 'vid_thumb.jpg';
        $vid_thmb_path = $output_dir . $thumb_tmp_name;
        $vid_name = "tmp";
        $vid_path = $output_dir . $vid_name;
        $fileLoader = new FileLoader();
        $files =  $_FILES["myfile"];
        $files["persist_name"] = $vid_name;
        $fileLoader -> uploadFiles($files,$output_dir);
        $ret = array();
        $ret[] = $vid_thmb_path;

        createMovieThumb(realpath($vid_path), $vid_thmb_path);
        $size = getimagesize($vid_thmb_path);

        $w = $size[0];
        $height = $size[1];
        $ret[1] = $w;
        $ret[2] = $height;
        $ret[3] = $vid_path;
        $info = new SplFileInfo($_FILES["myfile"]["name"]);
        $ret[4] = $fileName = $info->getExtension();
        echo json_encode($ret);

    }
}
function edit_update_vid_handler() {
    $vid_man = new VideoObjManager();

    $vid = $vid_man->selectVidByID($_POST["id"]);
    if ($vid != null) {
        $vid->setRusDescription($_POST["rus_desc"]);
        $vid->setEngDescription($_POST["eng_desc"]);

        $res = $vid_man->updateVideo($vid);

    } else {
        $res = 'No vid with submitted id';
    }
    echo $res;
}
function edit_del_vid_handler() {
    $vid = new Video($_POST['file_name']);
    $vid_man = new VideoObjManager();
    $res = $vid_man -> removeVideo($vid);
    echo $res;
}
function edit_save_vid_handler() {
    if (isset($_POST['w']) && isset($_POST['h']) && $_POST['h'] > 0 && $_POST['w'] > 0) {

        $crop = new VideoPicCropper($_POST['thmb_src'], $_POST['thmb_data'], $_POST['w'], $_POST['h']);
        $response = array(
            'state' => 200,
            'message' => $crop->getMsg(),
            'result' => $crop->getResult()
        );

        $fileName = $crop->getFileName();
        $info = new SplFileInfo($fileName);
        $thumb_ext = $info->getExtension();
        $baseName = $info->getBasename($thumb_ext);
        $videoName = $baseName . $_POST['vid_ext'];
        rename($_POST['vid_src'],'videos/' . $videoName);
        $vid = new Video($videoName,$fileName);
        //ImageHelper::addBgAndShadow($vid->getSketchPath());
        $vid_man = new VideoObjManager();
        $res = $vid_man -> saveVideo($vid);
    } else {
        $res = 'wrong input parameters';
    }
    echo $res;

}
function expo_save_handler() {

    $man = new ExpositionManager();
    $res = 'vid_id and song_id not setted up';

    if (isset($_POST["vid_id"]) or isset($_POST["song_id"]) )  {
        if (isset($_POST["vid_id"])) {
            $exp = $man->selectExpositionByPicID($_POST["vid_id"]);
            if ($exp == null) {
                $exp = new Exposition();
                $exp -> setPicId($_POST["vid_id"]);
                $man -> save($exp);
            }
        }  else {
            $exp = $man->selectExpositionBySongID($_POST["song_id"]);
            if ($exp == null) {
                $exp = new Exposition();
                $exp -> setSongId($_POST["song_id"]);
                $man -> save($exp);
            }
        }

        if (isset($_POST["left"])) {
            $exp->setLeft($_POST["left"]);
        }
        if (isset($_POST["width"])) {
            $exp->setWidth($_POST["width"]);
        }
        if (isset($_POST["ratio"])) {
            $exp->setRatio($_POST["ratio"]);
        }
        if (isset($_POST["top"])) {
            $exp->setTop($_POST["top"]);
        }

        $res = $man -> updateObject($exp);

    }

    echo $res;
}
function edit_get_gallery_handler() {
    $htmlGetter = new VideoHelper();
    if (isset($_POST['active_page'])) {
        $page = $_POST['active_page'];
    } else {
        $page = 1;
    }
    $gallery_html_code = $htmlGetter->getVideoEditHTMLCode($page);
    echo $gallery_html_code;
}
function edit_get_page_count_handler() {
    $galleryEditHtmlGetter = new VideoHelper();
    $count = $galleryEditHtmlGetter->getPageCount();
    echo $count;
}
function edit_get_pagination_handler() {
    $galleryEditHtmlGetter = new VideoHelper();
    if (isset($_POST['active_page'])) {
        $page = $_POST['active_page'];
    } else {
        $page = 1;
    }
    $pagination_html_code = $galleryEditHtmlGetter->getPaginationHtml($page);
    echo $pagination_html_code;
}

function createMovieThumb($srcFile, $destFile = "test.jpg")
{
    // Change the path according to your server.
    $ffmpeg_path = '/usr/local/bin/';

    $output = array();

    $cmd = sprintf('export DYLD_LIBRARY_PATH=\"\"; %sffmpeg -i %s -an -ss 00:00:05 -r 1 -vframes 1 -y %s',
        $ffmpeg_path, $srcFile, $destFile);

    if (strtoupper(substr(PHP_OS, 0, 3) == 'WIN'))
        $cmd = str_replace('/', DIRECTORY_SEPARATOR, $cmd);
    else
        $cmd = str_replace('\\', DIRECTORY_SEPARATOR, $cmd);

    exec($cmd, $output, $retval);

    if ($retval)
        return false;

    return $destFile;
}

require_once './router.php';
?>
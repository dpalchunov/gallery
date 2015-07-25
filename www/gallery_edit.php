<?php

require_once 'phplibs/ResourceService.php';
require_once './helpers.php';
actionHeader();

$actions = array(
    "edit_upload_pic" => array ("type" => "super_role"),
    "edit_update_pic" => array ("type" => "super_role"),
    "edit_del_pic" => array ("type" => "super_role"),
    "edit_save_pic" => array ("type" => "super_role"),
    "expo_save" => array ("type" => "super_role"),
    "edit_get_gallery" => array ("type" => "everyone"),
    "edit_get_page_count" => array ("type" => "everyone"),
    "edit_get_pagination" => array ("type" => "everyone")
);

function common_action_handler() {
    $viewer = new GalleryEditPageViewer();
    $viewer -> show($_POST);
}


function edit_upload_pic_handler() {
    if(isset($_FILES["myfile"]))
    {
        require_once 'phplibs/FileLoader.php';
        $output_dir = "uploads/pic_tmp/";
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
function edit_update_pic_handler() {
    $pic_man = new PictureObjManager();

    $pic = $pic_man->selectPicByID($_POST["id"]);
    if ($pic != null) {
        $pic->setRate($_POST["rate"]);
        $pic->setPosition($_POST["position"]);

        $pic->setRusDescription($_POST["rus_desc"]);
        $pic->setEngDescription($_POST["eng_desc"]);


        //update classification
        $gui_tmp = (array)json_decode($_POST["classification"]);
        $old_rels = $pic->getClassification();
        $new_rels = array();

        $gui_rels = array();
        foreach ($gui_tmp as $k => $v) {
            $gui_rels[(int)$k] = (int)$v;
        }

        foreach ($old_rels as $cl_rel) {
            $cl_id = $cl_rel->getClId();
            $cl_vid = $gui_rels[$cl_id];
            $cl_rel->setClvlID((int)$cl_vid);
            if ($cl_vid == 'to_remove') {
                $cl_rel->SetRemoveOnPersist(true);
            }
            array_push($new_rels, $cl_rel);
        }
        $pic->setClassification($new_rels);

        $res = $pic_man->updatePicture($pic);

    } else {
        $res = 'No pic with submitted id';
    }
    echo $res;
}
function edit_del_pic_handler() {
    $pic = new Picture($_POST['file_name']);
    $pic_man = new PictureObjManager();
    $res = $pic_man -> removePicture($pic);
    echo $res;
}
function edit_save_pic_handler() {
    if (isset($_POST['w']) && isset($_POST['h']) && $_POST['h'] > 0 && $_POST['w'] > 0) {

        $crop = new GalleryPicCropper($_POST['pic_src'], $_POST['pic_data'], $_POST['w'], $_POST['h']);
        $response = array(
            'state' => 200,
            'message' => $crop->getMsg(),
            'result' => $crop->getResult()
        );
        $fileName = $crop->getFileName();
        //  copy($_POST['pic_src'], 'images/gallary/' . $crop->getFileName());
        $pic = new Picture($fileName);
        //ImageHelper::addBgAndShadow($pic->getSketchPath());
        $pic_man = new PictureObjManager();
        $pic_id = $pic_man->savePicture($pic);
        if ($pic_id != null) {
            $man = new ExpositionManager();
            $exp = new Exposition();
            $exp -> setPicId($pic_id);

            $exp -> setRatio($_POST['h']/$_POST['w']);
            $exp -> setWidth(30);
            $res = $man -> save($exp);

        }
    } else {
        $res = 'wrong input parameters';
    }
    echo $res;

}
function expo_save_handler() {

    $man = new ExpositionManager();
    $res = 'pic_id and song_id not setted up';

    if (isset($_POST["pic_id"]) or isset($_POST["song_id"]) )  {
        if (isset($_POST["pic_id"])) {
            $exp = $man->selectExpositionByPicID($_POST["pic_id"]);
            if ($exp == null) {
                $exp = new Exposition();
                $exp -> setPicId($_POST["pic_id"]);
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
    $galleryEditHtmlGetter = new GalleryHelper();
    if (isset($_POST['active_page'])) {
        $page = $_POST['active_page'];
    } else {
        $page = 1;
    }
    $gallery_html_code = $galleryEditHtmlGetter->getGalleryEditHTMLCode($page);
    echo $gallery_html_code;
}

function edit_get_page_count_handler() {
    $galleryEditHtmlGetter = new GalleryHelper();
    $count = $galleryEditHtmlGetter->getPageCount();
    echo $count;
}

function edit_get_pagination_handler() {
    $galleryEditHtmlGetter = new GalleryHelper();
    if (isset($_POST['active_page'])) {
        $page = $_POST['active_page'];
    } else {
        $page = 1;
    }
    $pagination_html_code = $galleryEditHtmlGetter->getPaginationHtml($page);
    echo $pagination_html_code;
}

require_once './router.php';
?>
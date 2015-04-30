<?php

require_once 'phplibs/ResourceService.php';
require_once './helpers.php';
actionHeader();

$actions = array(
    "edit_upload_song" => array ("type" => "super_role"),
    "edit_update_song" => array ("type" => "super_role"),
    "edit_del_song" => array ("type" => "super_role"),
    "edit_save_song" => array ("type" => "super_role"),
    "expo_save" => array ("type" => "super_role"),
    "edit_get_songs" => array ("type" => "everyone"),
    "edit_get_page_count" => array ("type" => "everyone"),
    "edit_get_pagination" => array ("type" => "everyone")
);

function common_action_handler() {
    $viewer = new SongsEditPageViewer();
    $viewer -> show($_POST);
}


function removeSpecChar($str) {
    return  preg_replace("/[^a-zA-Z0-9._]/","_",$str);

}

function edit_upload_song_handler() {
    if(isset($_FILES["myfile"]))
    {
        require_once 'phplibs/FileLoader.php';
        $output_dir = "player/mp3/";
        $fileLoader = new FileLoader();
        $files =  $_FILES["myfile"];
        $files["persist_name"] = date('Y.m.d.His') . "." . pathinfo($_FILES["myfile"]["name"], PATHINFO_EXTENSION);;
        $ret = $fileLoader -> uploadFiles($files,$output_dir);

        $song = new Song($files["persist_name"]);
        $song -> setEngDescription($_FILES["myfile"]["name"]);
        $song -> setRusDescription($_FILES["myfile"]["name"]);
        $man = new SongsObjManager();
        $id = $man->saveSong($song);
        if ($id != null) {
            $man = new ExpositionManager();
            $exp = new Exposition();
            $exp -> setSongId($id);

            $exp -> setRatio(0.1);
            $exp -> setWidth(100);
            $res = $man -> save($exp);

        }

        echo $res;

    }
}
function edit_update_song_handler() {
    $man = new SongsObjManager();

    $song = $man->selectSongByID($_POST["id"]);
    if ($song != null) {
        $song->setRusDescription($_POST["rusname"]);
        $song->setEngDescription($_POST["engname"]);

        $res = $man->updateSong($song);

    } else {
        $res = 'No song with submitted id';
    }
    echo $res;
}
function edit_del_song_handler() {
    $man = new SongsObjManager();
    $song = $man ->selectSongByID($_POST['id']);
    $res = $man -> removeSong($song);
    echo $res;
}

function expo_save_handler() {
    $man = new ExpositionManager();
    $res = 'pic_id not setted up';

    if (isset($_POST["song_id"]))  {
        $exp = $man->selectExpositionBySongID($_POST["song_id"]);
        if ($exp == null) {
            $exp = new Exposition();
            $exp -> setSongId($_POST["song_id"]);
            $man -> save($exp);
        }
        $res = $man -> updateObject($exp);
    }

    echo $res;
}
function edit_get_songs_handler() {
    $htmlGetter = new SongsEditHtmlGetter();
    if (isset($_POST['active_page'])) {
        $page = $_POST['active_page'];
    } else {
        $page = 1;
    }
    $gallery_html_code = $htmlGetter->getHTMLCode($page);
    echo $gallery_html_code;
}

function edit_get_page_count_handler() {
    $htmlGetter = new SongsEditHtmlGetter();
    $count = $htmlGetter->getPageCount();
    echo $count;
}

function edit_get_pagination_handler() {
    $htmlGetter = new SongsEditHtmlGetter();
    if (isset($_POST['active_page'])) {
        $page = $_POST['active_page'];
    } else {
        $page = 1;
    }
    $pagination_html_code = $htmlGetter->getPaginationHtml($page);
    echo $pagination_html_code;
}

require_once './router.php';
?>
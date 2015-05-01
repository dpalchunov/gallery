<?php

require_once 'phplibs/ResourceService.php';
require_once './helpers.php';
actionHeader();

$actions = array(
    "common_action_" => array ("type" => "everyone"),
    "get_pic_page" => array ("type" => "everyone"),
    "get_play_list" => array ("type" => "everyone"),
    "get_song_page" => array ("type" => "everyone"),
    "get_pic_count_by_filter" => array ("type" => "everyone")
);

function common_action_handler() {
    return;
}

function get_pic_page_handler() {
    $resourceService = new ResourceService();
    $lang = $resourceService -> getLang();
    $picturesGetter = new PicturesGetter($lang);
    $pageNum = $_POST['pageNum'];
    $filter = $_POST;
    unset($filter['pageNum']);
    unset($filter['lang']);
    unset($filter['action']);
    echo $picturesGetter->getPicExposition($lang);
}

function get_play_list_handler() {
    $resourceService = new ResourceService();
    $lang = $resourceService -> getLang();
    $r = array();
    $pm = new SongsObjManager();
    $objectArray = $pm -> selectAllSongs();
    if ($objectArray != null) {
        foreach ($objectArray as $obj) {
            $a = array();
            $path = $obj->getPath();
            $title = $obj->getDescription($lang);
            $a['title'] = $title;
            $a['mp3'] = $path;
            array_push($r,$a);
        }
    }
    $j = json_encode($r);
    echo $j;
}
function get_song_page_handler() {
    $resourceService = new ResourceService();
    $lang = $resourceService -> getLang();
    $getter = new SongsGetter($lang);
    $filter = $_POST;
    unset($filter['lang']);
    unset($filter['action']);
    echo $getter->getSongsExposition($lang);
}




function get_pic_count_by_filter() {
    $resourceService = new ResourceService();
    $lang = $resourceService -> getLang();
    $picturesGetter = new PicturesGetter($lang);
    $filter = $_POST;
    unset($filter['action']);
    echo $picturesGetter->getPicturesCountByFilter($filter);
}


require_once './router.php';
?>

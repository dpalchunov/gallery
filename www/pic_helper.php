<?php

require_once 'phplibs/ResourceService.php';

    if ( isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'get_pic_page') {
            $resourceService = new ResourceService();
            $lang = $resourceService -> getLang();
            $picturesGetter = new PicturesGetter($lang);
            $pageNum = $_POST['pageNum'];
            $filter = $_POST;
            unset($filter['pageNum']);
            unset($filter['lang']);
            unset($filter['action']);
            echo $picturesGetter->getPicExposition($lang);
        }   else if ($action == 'get_pic_count_by_filter') {
            $resourceService = new ResourceService();
            $lang = $resourceService -> getLang();
            $picturesGetter = new PicturesGetter($lang);
            $filter = $_POST;
            unset($filter['action']);
            echo $picturesGetter->getPicturesCountByFilter($filter);
        }
    }
?>
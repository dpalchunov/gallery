<?php
    require_once 'phplibs/ResourceService.php';

    $post = $_POST;
    if (isset($post['action'])) {
        if ($post['action'] == 'get_avas_array') {
            $persistedAvasGetter = new PersistedAvasGetter();
            $jsArrayHtml = $persistedAvasGetter->getAvasArray();
            $result = json_encode($jsArrayHtml);
            echo $result;
        }
    } else {

        $persistedAvasGetter = new PersistedAvasGetter();
        $persisted_avas_html_code = $persistedAvasGetter->generateAvasHtml();
        echo $persisted_avas_html_code;
    }


?>
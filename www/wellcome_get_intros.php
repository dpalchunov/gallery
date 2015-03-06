<?php
    require_once 'phplibs/ResourceService.php';

    $post = $_POST;
    if (isset($post['action'])) {
        if ($post['action'] == 'get_avas_array') {
            $persistedPicsGetter = new PersistedIntrosGetter();
            $jsArrayHtml = $persistedPicsGetter->getAvasArray();
            $result = json_encode($jsArrayHtml);
            echo $result;
        }
    } else {

        $persistedPicsGetter = new PersistedIntrosGetter();
        $persisted_avas_html_code = $persistedPicsGetter->generatePicsHtmlForEdit();
        echo $persisted_avas_html_code;
    }


?>
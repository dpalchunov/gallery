<?php
    require_once 'phplibs/ResourceService.php';
    $persistedAvasGetter = new PersistedAvasGetter();
    $persisted_avas_html_code = $persistedAvasGetter->generateAvasHtml();
    echo $persisted_avas_html_code;
?>
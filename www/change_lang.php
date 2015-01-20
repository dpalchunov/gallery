<?php
    require_once 'phplibs/ResourceService.php';
    $resourceService = new ResourceService();
    $resourceService -> changeLang();
    echo $_COOKIE['lang'];
?>
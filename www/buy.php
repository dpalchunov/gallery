<?php
require_once 'phplibs/ResourceService.php';
$buyPage = new BuyPageViewer();
$buyPage -> show($_POST);
?>
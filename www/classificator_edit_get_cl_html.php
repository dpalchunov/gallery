<?php
require_once 'phplibs/ResourceService.php';
$getter = new ClassificatorEditHtmlGetter();
$m = new ClassificatorManager();
$cl = $m->selectClByID($_POST['id']);
$html_code = $getter->getClHtmlCode($cl);
echo $html_code;
?>
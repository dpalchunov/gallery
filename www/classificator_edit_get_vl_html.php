<?php
require_once 'phplibs/ResourceService.php';
$getter = new ClassificatorEditHtmlGetter();
$m = new ClassificatorManager();
$vl = $m->selectVlByID($_POST['id']);
$html_code = $getter->getVlHtmlCode($vl);
echo $html_code;
?>
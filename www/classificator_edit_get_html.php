<?php
require_once 'phplibs/ResourceService.php';
$getter = new ClassificatorEditHtmlGetter();
$html_code = $getter->getHTMLCode();
echo $html_code;
?>
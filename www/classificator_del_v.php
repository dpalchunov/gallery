<?php

require_once 'phplibs/ClassificatorManager.php';
$man = new ClassificatorManager();

$res = $man->removeVlByID($_POST["id"]);
echo $res;

?>
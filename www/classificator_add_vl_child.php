<?php

require_once 'phplibs/ClassificatorManager.php';
$man = new ClassificatorManager();

$res = $man->removeClByID($_POST["id"]);
echo $res;

?>
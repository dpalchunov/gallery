<?php

require_once 'phplibs/ClassificatorManager.php';
$man = new ClassificatorManager();
$res = $man->getValuesPaths();
echo json_encode($res);

?>
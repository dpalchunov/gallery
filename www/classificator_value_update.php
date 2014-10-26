<?php
require_once 'phplibs/Picture.php';
require_once 'phplibs/ClassificatorManager.php';
$man = new ClassificatorManager();

$vl = $man->selectVlByID($_POST["id"]);
if ($vl != null) {
    $vl->setRusName($_POST["rus_value"]);
    $vl->setEngName($_POST["eng_value"]);


    $res = $man->updateVl($vl);
} else {
    $res = 'No classifier value with submitted id';
}
echo $res;
?>
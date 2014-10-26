<?php
require_once 'phplibs/Picture.php';
require_once 'phplibs/ClassificatorManager.php';
$man = new ClassificatorManager();

$cl = $man->selectClByID($_POST["id"]);
if ($cl != null) {
    $cl->setRusName($_POST["rus_name"]);
    $cl->setEngName($_POST["eng_name"]);

    $res = $man->updateCl($cl);
} else {
    $res = 'No cl with submitted id';
}
echo $res;
?>
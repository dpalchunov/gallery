<?php
require_once 'phplibs/Exposition.php';
require_once 'phplibs/ClassificatorManager.php';
$man = new ExpositionManager();
$res = 'pic_id not setted up';

if (isset($_POST["pic_id"]))  {
    $exp = $man->selectExpositionByPicID($_POST["pic_id"]);
    if ($exp == null) {
        $exp = new Exposition();
        $exp -> setPicId($_POST["pic_id"]);
        $man -> save($exp);
    }

    if (isset($_POST["left"])) {
        $exp->setLeft($_POST["left"]);
    }
    if (isset($_POST["width"])) {
        $exp->setWidth($_POST["width"]);
    }
    if (isset($_POST["ratio"])) {
        $exp->setRatio($_POST["ratio"]);
    }
    if (isset($_POST["top"])) {
        $exp->setTop($_POST["top"]);
    }

    $res = $man -> updateObject($exp);

}

echo $res;
?>
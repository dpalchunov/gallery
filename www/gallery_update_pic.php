<?php
    require_once 'phplibs/Picture.php';
    require_once 'phplibs/PictureObjManager.php';
    $pic_man = new PictureObjManager();
    $pic =  $pic_man -> selectPic();
    $res = $pic_man -> savePicture($pic);
    echo $res;
?>
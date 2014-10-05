<?php
    require_once 'phplibs/Picture.php';
    require_once 'phplibs/PictureObjManager.php';
    $pic = new Picture($_POST['file_name']);
    $pic_man = new PictureObjManager();
    $res = $pic_man -> removePicture($pic);
    echo $res;

?>
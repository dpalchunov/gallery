<?php
    require_once 'phplibs/Picture.php';
    require_once 'phplibs/PictureObjManager.php';
    $pic_man = new PictureObjManager();

    $pic =  $pic_man -> selectPicByID($_POST["id"]);
    if ($pic != null)  {
        $pic->setRate($_POST["rate"]);
        $pic->setPosition($_POST["position"]);

        $pic->setRusDescription($_POST["rus_desc"]);
        $pic->setEngDescription($_POST["eng_desc"]);

        $res = $pic_man -> updatePicture($pic);
    }  else {
        $res = 'No pic with submitted id';
    }
    echo $res;
?>
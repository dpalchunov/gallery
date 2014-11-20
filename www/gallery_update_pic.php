<?php
require_once 'phplibs/Picture.php';
require_once 'phplibs/PictureObjManager.php';
$pic_man = new PictureObjManager();

$pic = $pic_man->selectPicByID($_POST["id"]);
if ($pic != null) {
    $pic->setRate($_POST["rate"]);
    $pic->setPosition($_POST["position"]);

    $pic->setRusDescription($_POST["rus_desc"]);
    $pic->setEngDescription($_POST["eng_desc"]);


    //update classification
    $gui_tmp = (array)json_decode($_POST["classification"]);
    $old_rels = $pic->getClassification();
    $new_rels = array();

    $gui_rels = array();
    foreach ($gui_tmp as $k => $v) {
        $gui_rels[(int)$k] = (int)$v;
    }

    foreach ($old_rels as $cl_rel) {
        $cl_id = $cl_rel->getClId();
        $cl_vid = $gui_rels[$cl_id];
        $cl_rel->setClvlID((int)$cl_vid);
        if ($cl_vid == 'to_remove') {
            $cl_rel->SetRemoveOnPersist(true);
        }
        array_push($new_rels, $cl_rel);
    }
    $pic->setClassification($new_rels);

    $res = $pic_man->updatePicture($pic);

} else {
    $res = 'No pic with submitted id';
}
echo $res;
?>
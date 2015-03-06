<?php
$output_dir = "uploads/intros_tmp/";


function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
            .substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
        return $uuid;
    }
}


if(isset($_FILES["myfile"]))
{

    require_once 'phplibs/FileLoader.php';
    $fileLoader = new FileLoader();
    $files =  $_FILES["myfile"];
    $files["persist_name"] = "tmp";
    $ret = $fileLoader -> uploadFiles($files,$output_dir);
    $size = getimagesize($ret[0]);
    $w = $size[0];
    $height = $size[1];
    $ret[1] = $w;
    $ret[2] = $height;
    echo json_encode($ret);

}

?>
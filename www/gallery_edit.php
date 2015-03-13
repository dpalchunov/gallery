<?php

require_once 'phplibs/ResourceService.php';
$output_dir = "uploads/pic_tmp/";


session_start();
if ( isset($_SESSION['state'])) {
    if ( isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'edit_upload_pic') {
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
        }   else if ($action == 'edit_update_pic') {
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
        }   else if ($action == 'edit_del_pic') {
            $pic = new Picture($_POST['file_name']);
            $pic_man = new PictureObjManager();
            $res = $pic_man -> removePicture($pic);
            echo $res;
        }   else if ($action == 'edit_save_pic') {
            if (isset($_POST['w']) && $_POST['h'] && $_POST['w'] > 0 && $_POST['w'] > 0) {

                $crop = new CropPic($_POST['pic_src'], $_POST['pic_data'], $_POST['w'], $_POST['h']);
                $response = array(
                    'state' => 200,
                    'message' => $crop->getMsg(),
                    'result' => $crop->getResult()
                );
                $fileName = $crop->getFileName();
                //  copy($_POST['pic_src'], 'images/gallary/' . $crop->getFileName());
                $pic = new Picture($fileName);
//ImageHelper::addBgAndShadow($pic->getSketchPath());
                $pic_man = new PictureObjManager();
                $pic_id = $pic_man->savePicture($pic);
                if ($pic_id != null) {
                    $man = new ExpositionManager();
                    $exp = new Exposition();
                    $exp -> setPicId($pic_id);

                    $exp -> setRatio($_POST['h']/$_POST['w']);
                    $exp -> setWidth(30);
                    $res = $man -> save($exp);

                }
            } else {
                $res = 'wrong input parameters';
            }
            echo $res;

        }   else if ($action == 'expo_save') {
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
        }   else if ($action == 'edit_get_gallery') {

            $galleryEditHtmlGetter = new GalleryEditHtmlGetter();
            if (isset($_POST['active_page'])) {
                $page = $_POST['active_page'];
            } else {
                $page = 1;
            }
            $gallery_html_code = $galleryEditHtmlGetter->getHTMLCode($page);
            echo $gallery_html_code;
        }   else if ($action == 'edit_get_page_count') {
            $galleryEditHtmlGetter = new GalleryEditHtmlGetter();
            $count = $galleryEditHtmlGetter->getPageCount($page);
            echo $count;

        }   else if ($action == 'edit_get_pagination') {
            $galleryEditHtmlGetter = new GalleryEditHtmlGetter();
            if (isset($_POST['active_page'])) {
                $page = $_POST['active_page'];
            } else {
                $page = 1;
            }
            $pagination_html_code = $galleryEditHtmlGetter->getPaginationHtml($page);
            echo $pagination_html_code;
        }
    } else {
        $viewer = new GalleryEditPageViewer();
        $viewer -> show($_POST);
    }
}
else {
    echo 'page not found';
}


class CropPic
{
    private $src;
    private $data;
    private $fileName;
    private $dst;
    private $thumb;
    private $dst_h;
    private $dst_w;
    private $type;
    private $extension;
    private $dstDir = 'images/gallary/sketches';
    private $thumbDir = 'images/gallary';
    private $msg;

    function __construct($src, $data, $dst_w, $dst_h)
    {
        $this->setSrc($src);
        $this->setData($data);
        $this->dst_h = $dst_h;
        $this->dst_w = $dst_w;
        $this->crop($this->src, $this->dst, $this->thumb, $this->data);

    }

    private function setSrc($src)
    {
        if (!empty($src)) {
            $type = exif_imagetype($src);

            if ($type) {
                $this->src = $src;
                $this->type = $type;
                $this->extension = image_type_to_extension($type);
                $this->setDst();
            }
        }
    }

    private function setData($data)
    {
        if (!empty($data)) {
            $this->data = json_decode(stripslashes($data));
        }
    }


    private function setDst()
    {
        $dir = $this->dstDir;
        $thumb_dir = $this->thumbDir;

        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }
        $this->fileName = date('YmdHis') . $this->extension;
        $this->dst = $dir . '/' . $this->fileName;
        $this->thumb = $thumb_dir . '/' . $this->fileName;
    }

    private function crop($src, $dst, $thumbnail, $data)
    {
        if (!empty($src) && !empty($dst) && !empty($data)) {
            switch ($this->type) {
                case IMAGETYPE_GIF:
                    $src_img = imagecreatefromgif($src);
                    break;

                case IMAGETYPE_JPEG:
                    $src_img = imagecreatefromjpeg($src);
                    break;

                case IMAGETYPE_PNG:
                    $src_img = imagecreatefrompng($src);
                    break;
            }

            if (!$src_img) {
                $this->msg = "Failed to read the image file";
                return;
            }

            $dst_img = imagecreatetruecolor($this->dst_w, $this->dst_h);

            $src_part_w = $data->width;
            $src_part_h = $data->height;

            if ($src_part_w <= 1900 and $src_part_h <= 1600) {
                $thumb_w = $src_part_w;
                $thumb_h = $src_part_h;
            } else {
                $ratio = $src_part_w / $src_part_h;
                if ((($src_part_w) / 1900) >= ($src_part_h) / 1600) {
                    $thumb_w = 1900;
                    $thumb_h = $thumb_w = $thumb_w / $ratio;
                } else {
                    $thumb_h = 1600;
                    $thumb_w = $thumb_h * $ratio;
                }
            }
            $thumb_w = round($thumb_w);
            $thumb_h = round($thumb_h);
            trigger_error($thumb_w . ' -x ' . $thumb_h . ' -y');
            $thumb_img = imagecreatetruecolor($thumb_w, $thumb_h);
            $result = (imagecopyresampled($dst_img, $src_img, 0, 0, $data->x, $data->y, $this->dst_w, $this->dst_h, $data->width, $data->height) and
                imagecopyresampled($thumb_img, $src_img, 0, 0, $data->x, $data->y, $thumb_w, $thumb_h, $data->width, $data->height));

            if ($result) {
                switch ($this->type) {
                    case IMAGETYPE_GIF:
                        $result = (imagegif($dst_img, $dst) and imagegif($thumb_img, $thumbnail));
                        break;

                    case IMAGETYPE_JPEG:
                        $result = (imagejpeg($dst_img, $dst) and imagegif($thumb_img, $thumbnail));
                        break;

                    case IMAGETYPE_PNG:
                        $result = (imagepng($dst_img, $dst) and imagegif($thumb_img, $thumbnail));
                        break;
                }

                if (!$result) {
                    $this->msg = "Failed to save the cropped image file";
                }
            } else {
                $this->msg = "Failed to crop the image file";
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);
            imagedestroy($thumb_img);
        }
    }

    private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                break;

            case UPLOAD_ERR_FORM_SIZE:
                $message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                break;

            case UPLOAD_ERR_PARTIAL:
                $message = 'The uploaded file was only partially uploaded';
                break;

            case UPLOAD_ERR_NO_FILE:
                $message = 'No file was uploaded';
                break;

            case UPLOAD_ERR_NO_TMP_DIR:
                $message = 'Missing a temporary folder';
                break;

            case UPLOAD_ERR_CANT_WRITE:
                $message = 'Failed to write file to disk';
                break;

            case UPLOAD_ERR_EXTENSION:
                $message = 'File upload stopped by extension';
                break;

            default:
                $message = 'Unknown upload error';
        }

        return $message;
    }

    public function getResult()
    {
        return !empty($this->data) ? $this->dst : $this->src;
    }

    public function getMsg()
    {
        return $this->msg;
    }

    public function getFileName()
    {
        return $this->fileName;
    }


}


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

?>
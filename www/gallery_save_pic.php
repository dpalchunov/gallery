<?php
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
    private $thumbDir = 'images/gallary/mini';
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

            if ($src_part_w <= 800 and $src_part_h <= 600) {
                $thumb_w = $src_part_w;
                $thumb_h = $src_part_h;
            } else {
                $ratio = $src_part_w / $src_part_h;
                if ((($src_part_w) / 800) >= ($src_part_h) / 600) {
                    $thumb_w = 800;
                    $thumb_h = $thumb_w = $thumb_w / $ratio;
                } else {
                    $thumb_h = 600;
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

require_once 'phplibs/Picture.php';
require_once 'phplibs/PictureObjManager.php';

if (isset($_POST['w']) && $_POST['h'] && $_POST['w'] > 0 && $_POST['w'] > 0) {

    $crop = new CropPic($_POST['pic_src'], $_POST['pic_data'], $_POST['w'], $_POST['h']);
    $response = array(
        'state' => 200,
        'message' => $crop->getMsg(),
        'result' => $crop->getResult()
    );
    $fileName = $crop->getFileName();
    copy($_POST['pic_src'], 'images/gallary/' . $crop->getFileName());
    $pic = new Picture($fileName);
//ImageHelper::addBgAndShadow($pic->getSketchPath());
    $pic_man = new PictureObjManager();
    $pic_id = $pic_man->savePicture($pic);
    if ($pic_id != null) {
        $man = new ExpositionManager();
        $exp = new Exposition();
        $exp -> setPicId($pic_id);

        $exp -> setRatio($_POST['h']/$_POST['w']);
        $exp -> setWidth($_POST['w']);
        $res = $man -> save($exp);

    }
} else {
    $res = 'wrong input parameters';
}
echo $res;
?>
<?php
class CropPic {
    private $src;
    private $data;
    private $fileName;
    private $dst;
    private $dst_h;
    private $dst_w;
    private $type;
    private $extension;
    private $dstDir = 'images/gallary/sketches';
    private $msg;

    function __construct($src, $data,$dst_w,$dst_h) {
        $this -> setSrc($src);
        $this -> setData($data);
        $this -> dst_h = $dst_h;
        $this -> dst_w = $dst_w;
        $this -> crop($this -> src, $this -> dst, $this -> data);

    }

    private function setSrc($src) {
        if (!empty($src)) {
            $type = exif_imagetype($src);

            if ($type) {
                $this -> src = $src;
                $this -> type = $type;
                $this -> extension = image_type_to_extension($type);
                $this -> setDst();
            }
        }
    }

    private function setData($data) {
        if (!empty($data)) {
            $this -> data = json_decode(stripslashes($data));
        }
    }


    private function setDst() {
        $dir = $this -> dstDir;

        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }
        $this -> fileName = date('YmdHis') . $this -> extension;
        $this -> dst = $dir . '/' . $this -> fileName;
    }

    private function crop($src, $dst, $data) {
        if (!empty($src) && !empty($dst) && !empty($data)) {
            switch ($this -> type) {
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
                $this -> msg = "Failed to read the image file";
                return;
            }

            $dst_img = imagecreatetruecolor($this-> dst_w, $this -> dst_h);
            $result = imagecopyresampled($dst_img, $src_img, 0, 0, $data -> x, $data -> y, $this-> dst_w, $this-> dst_h, $data -> width, $data -> height);

            if ($result) {
                switch ($this -> type) {
                    case IMAGETYPE_GIF:
                        $result = imagegif($dst_img, $dst);
                        break;

                    case IMAGETYPE_JPEG:
                        $result = imagejpeg($dst_img, $dst);
                        break;

                    case IMAGETYPE_PNG:
                        $result = imagepng($dst_img, $dst);
                        break;
                }

                if (!$result) {
                    $this -> msg = "Failed to save the cropped image file";
                }
            } else {
                $this -> msg = "Failed to crop the image file";
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
    }

    private function codeToMessage($code) {
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

    public function getResult() {
        return !empty($this -> data) ? $this -> dst : $this -> src;
    }

    public function getMsg() {
        return $this -> msg;
    }

    public function getFileName() {
        return $this -> fileName;
    }


}

    $crop = new CropPic($_POST['pic_src'],$_POST['pic_data'],$_POST['w'],$_POST['h']);
    $response = array(
        'state'  => 200,
        'message' => $crop -> getMsg(),
        'result' => $crop -> getResult()
    );
    copy($_POST['pic_src'],'images/gallary/'. $crop -> getFileName());
    $file_name = basename($_POST['pic_src']);
    $pic = new $Picture($file_name);
    $pic_saver = new PictureSaver();
    $res = $pic_saver -> savePicture($pic);
    echo $res;
?>
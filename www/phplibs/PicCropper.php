<?php
abstract class PicCropper
{
    public $src;
    public $data;
    public $file;
    public $dst;
    public $type;
    public $extension;
    public $srcDir;
    public $dstDir;
    public $msg;

    abstract public function crop($src, $dst, $data);


    function PicCropper($src, $data)
    {
        $this->setSrc($src);
        $this->setData($data);
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

        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }

        $this->dst = $dir . '/' . date('YmdHis') . $this->extension;
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
}

?>
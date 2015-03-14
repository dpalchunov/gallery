<?php
class GalleryPicCropper extends PicCropper
{

    private $thumbDir = 'images/gallary';
    private $fileName;
    private $thumb;
    private $dst_h;
    private $dst_w;

    public function getFileName()
    {
        return $this->fileName;
    }

    function GalleryPicCropper($src, $data, $dst_w, $dst_h)
    {
        $this->srcDir = '';
        $this->dstDir = 'images/gallary/sketches';
        parent::PicCropper($src,$data);
        $this->dst_h = $dst_h;
        $this->dst_w = $dst_w;
        $this->crop();
    }

    public function setDst() {
        parent::setDst();
        $dir = $this->dstDir;
        $thumb_dir = $this->thumbDir;

        if (!file_exists($dir)) {
            mkdir($dir, 0777);
        }
        $this->fileName = date('YmdHis') . $this->extension;
        $this->thumb = $thumb_dir . '/' . $this->fileName;
    }

    public function crop()
    {
        $src  = $this -> src;
        $dst  = $this -> dst;
        $data = $this -> data;
        $thumbnail = $this -> thumb;
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
            //trigger_error($thumb_w . ' -x ' . $thumb_h . ' -y');
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

}

?>
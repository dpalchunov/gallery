<?php
class AvatarCropper extends PicCropper
{

    function AvatarCropper($src, $data)
    {
        $this->srcDir = 'uploads/ava_tmp';
        $this->dstDir = 'images/slider/avas';
        parent::PicCropper($src,$data);
        $this->crop($this->src, $this->dst, $this->data);
    }



    public function crop($src, $dst, $data)
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

            $dst_w = 400;
            $ratio = ($data->width) / ($data->height);
            $dst_h = $dst_w / $ratio;

            $dst_img = imagecreatetruecolor($dst_w, $dst_h);
            $result = imagecopyresampled($dst_img, $src_img, 0, 0, $data->x, $data->y, $dst_w, $dst_h, $data->width, $data->height);

            if ($result) {
                switch ($this->type) {
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
                    $this->msg = "Failed to save the cropped image file";
                }
            } else {
                $this->msg = "Failed to crop the image file";
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
    }
}

?>
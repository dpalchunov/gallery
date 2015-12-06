<?php
class EventsPicCropper extends PicCropper
{

    function EventsPicCropper($src, $data)
    {
        $this->srcDir = 'uploads/events_tmp';
        $this->dstDir = 'images/events';
        parent::PicCropper($src,$data);

    }



    public function crop()
    {
        $response = array();
        $src  = $this -> src;
        $dst  = $this -> dst;
        $data = $this -> data;
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
                $response =  "Failed to read the image file";
            }


            $size = getimagesize($src);
            $w = $size[0];
            $height = $size[1];


            $dst_img = imagecreatetruecolor($w*($data[2]-$data[0]), $height*($data[3]-$data[1]));
            $result = imagecopyresampled($dst_img, $src_img, 0, 0, $w*$data[0], $height*$data[1], $w*($data[2]-$data[0]), $height*($data[3]-$data[1]), $w*($data[2]-$data[0]), $height*($data[3]-$data[1]));

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
                    $response = "Failed to save the cropped image file";
                } else {
                    $response["url"] = $dst;
                    $response["size"] = $size;
                }
            } else {
                $response = "Failed to crop the image file";
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);
        }  else {
            $response["src"] = $src;
            $response["dst"] = $dst;
            $response["data"] = $data;
            return $response;
        }
        return $response;
    }
}

?>
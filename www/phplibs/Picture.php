<?php
class  Picture
{
    var $picsFolder = './images/gallary/';
    var $sketchesFolder = './images/gallary/sketches/';
    var $thumbFolder = './images/gallary/mini/';
    var $sketchPath;
    var $picPath;
    var $thumbnail;
    var $rate;
    var $position;
    var $multilangDescription;
    var $fileName;
    var $id;
    var $classification;
    var $expo_position;

    /**
     * @param mixed $expo_position
     */
    public function setExpoPosition($expo_position)
    {
        $this->expo_position = $expo_position;
    }

    /**
     * @return mixed
     */
    public function getExpoPosition()
    {
        return $this->expo_position;
    }




    /**
     * @param mixed $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }


    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }


    public function __construct1($fileName)
    {
        $position = 0;
        $rate = 2;
        $multilangDescription = array('rus' => '', 'eng' => '');

        $this->setfileName($fileName);
        $picPath = $this->generatePicPath();
        $sketchPath = $this->generateSketchPath();
        $thumbPath = $this->generateThumbPath();
        $this->setPicPath($picPath);
        $this->setSketchPath($sketchPath);
        $this->setThumbnail($thumbPath);
        $this->setRate($rate);
        $this->setPosition($position);
        $this->setMultilangDescription($multilangDescription);
    }


    public function __construct8($fileName, $position, $rate,
                                 $multilangDescription,
                                 $picPath, $sketchPath, $thumbnail, $id)
    {
        $this->setfileName($fileName);
        $this->setPicPath($picPath);
        $this->setSketchPath($sketchPath);
        $this->setRate($rate);
        $this->setPosition($position);
        $this->setID($id);
        $this->setMultilangDescription($multilangDescription);
        $this->setThumbnail($thumbnail);
    }

    public function __construct9($fileName, $position, $rate,
                                 $multilangDescription,
                                 $picPath, $sketchPath, $thumbnail, $id, $classification)
    {
        $this->setfileName($fileName);
        $this->setPicPath($picPath);
        $this->setSketchPath($sketchPath);
        $this->setRate($rate);
        $this->setPosition($position);
        $this->setID($id);
        $this->setMultilangDescription($multilangDescription);
        $this->setClassification($classification);
        $this->setThumbnail($thumbnail);
    }


    public function __construct10($fileName, $position, $rate,
                                 $multilangDescription,
                                 $picPath, $sketchPath, $thumbnail, $id, $classification,$expo_position)
    {
        $this -> __construct9($fileName, $position, $rate,
            $multilangDescription,
            $picPath, $sketchPath, $thumbnail, $id, $classification);

        $this->setExpoPosition($expo_position);
    }

    private function generatePicPath()
    {
        $res = $this->picsFolder . $this->fileName;
        return $res;
    }

    private function generateSketchPath()
    {
        $res = $this->sketchesFolder . $this->fileName;
        return $res;
    }

    private function generateThumbPath()
    {
        $res = $this->thumbFolder . $this->fileName;
        return $res;
    }


    public function setPicPath($path)
    {
        $this->picPath = $path;
    }

    public function setSketchPath($path)
    {
        $this->sketchPath = $path;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function setMultilangDescription($desc)
    {
        $this->multilangDescription = $desc;
    }

    public function setRusDescription($lang)
    {
        return $this->multilangDescription['rus'] = $lang;
    }

    public function setEngDescription($lang)
    {
        return $this->multilangDescription['eng'] = $lang;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function setClassification($classification)
    {
        $this->classification = $classification;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

    }

    public function setID($id)
    {
        $this->id = $id;

    }

    public function getPicPath()
    {
        return $this->picPath;
    }

    public function getSketchPath()
    {
        return $this->sketchPath;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getClassification()
    {
        return $this->classification;
    }

    public function getDescription($lang)
    {
        return $this->multilangDescription[$lang];
    }

    public function getMultilangDescription()
    {
        return $this->multilangDescription;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function getID()
    {
        return $this->id;
    }


}

?>

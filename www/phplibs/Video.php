<?php
class  Video
{
    var $videosFolder = './videos/';
    var $thumbFolder = './videos/thumbs/';
    var $path;
    var $thumbnail;
    var $position;
    var $multilangDescription;
    var $fileName;
    var $id;

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
        $multilangDescription = array('rus' => '', 'eng' => '');
        $this->setfileName($fileName);
        $picPath = $this->generatePath();
        $thumbPath = $this->generateThumbPath();
        $this->setPath($picPath);
        $this->setThumbnail($thumbPath);
        $this->setPosition($position);
        $this->setMultilangDescription($multilangDescription);
    }


    public function __construct6($fileName, $position,
                                 $multilangDescription,
                                 $path, $thumbnail, $id)
    {
        $this->setfileName($fileName);
        $this->setpath($path);
        $this->setPosition($position);
        $this->setID($id);
        $this->setMultilangDescription($multilangDescription);
        $this->setThumbnail($thumbnail);
    }

    private function generatePath()
    {
        $res = $this->videosFolder . $this->fileName;
        return $res;
    }

    public function generateThumbPath()
    {
        $res = $this->thumbFolder . $this->fileName;
        return $res;
    }


    public function setPath($path)
    {
        $this->path = $path;
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

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

    }

    public function setID($id)
    {
        $this->id = $id;

    }

    public function getPosition()
    {
        return $this->position;
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


    public function getPath()
    {
        return $this->path;
    }


}

?>

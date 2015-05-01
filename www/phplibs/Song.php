<?php
class  Song
{
    var $songsFloder = './player/mp3/';
    var $multilangDescription;
    var $fileName;
    var $path;
    var $id;
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
        $multilangDescription = array('rus' => '', 'eng' => '');

        $this->setfileName($fileName);
        $path = $this->generatePath();
        $this->setPath($path);
        $this->setMultilangDescription($multilangDescription);
    }


    public function __construct3($fileName,
                                 $multilangDescription,
                                 $id)
    {

        $this->setfileName($fileName);
        $path = $this->generatePath();
        $this->setPath($path);
        $this->setMultilangDescription($multilangDescription);
        $this->setID($id);
    }


    public function __construct4($fileName,
                                 $multilangDescription,
                                 $id,$expo_position)
    {
        $this -> __construct3($fileName,
            $multilangDescription,
            $id);

        $this->setExpoPosition($expo_position);
    }

    private function generatePath()
    {
        $res = $this->songsFloder . $this->fileName;
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


    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

    }

    public function setID($id)
    {
        $this->id = $id;

    }

    public function getPath()
    {
        return $this->path;
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

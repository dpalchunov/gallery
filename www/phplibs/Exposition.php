<?php
class  Exposition
{

    var $id;
    var $pic_id;
    var $song_id;
    var $left;
    var $width;
    var $ratio;
    var $top;

    /**
     * @param mixed $top
     */
    public function setTop($top)
    {
        $this->top = $top;
    }

    /**
     * @return mixed
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * @param mixed $pic_id
     */
    public function setPicId($pic_id)
    {
        $this->pic_id = $pic_id;
    }

    public function setSongId($song_id)
    {
        $this->song_id = $song_id;
    }

    /**
     * @return mixed
     */
    public function getPicId()
    {
        return $this->pic_id;
    }

    public function getSongId()
    {
        return $this->song_id;
    }


    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }




    public function __construct7($id,$pic_id,$song_id,$left, $width,$top, $ratio)
    {
        $this -> setId($id);
        $this -> setPicId($pic_id);
        $this -> setSongId($song_id);
        $this -> setLeft($left);
        $this -> setWidth($width);
        $this -> setRatio($ratio);
        $this -> setTop($top);
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $left
     */
    public function setLeft($left)
    {
        $this->left = $left;
    }

    /**
     * @return mixed
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @param mixed $ratio
     */
    public function setRatio($ratio)
    {
        $this->ratio = $ratio;
    }

    /**
     * @return mixed
     */
    public function getRatio()
    {
        return $this->ratio;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }






}

?>

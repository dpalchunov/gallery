<?php
class  ClassificatorValue
{

    var $rusname;
    var $engname;
    var $id;
    var $parent_id;
    var $values;
    var $level;
    var $path;

    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }





    public function __construct4($rusname, $engname, $id, $parent_id)
    {
        $this->setID($id);
        $this->setRusName($rusname);
        $this->setEngName($engname);
        $this->parent_id = $parent_id;
        $this->setValues(array());
    }


    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level)
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    public function setID($id)
    {
        $this->id = $id;

    }

    public function setParentID($parent_id)
    {
        $this->parent_id = $parent_id;

    }

    public function setRusName($rusname)
    {
        $this->rusname = $rusname;
    }

    public function setEngName($engname)
    {
        $this->engname = $engname;
    }

    public function setValues($values)
    {
        $this->values = $values;
    }

    public function getRusName()
    {
        return $this->rusname;
    }

    public function getEngName()
    {
        return $this->engname;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getParentID()
    {
        return $this->parent_id;
    }
}

?>

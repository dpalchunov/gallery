<?php
class  ClassificatorValue
{

    var $rusvalue;
    var $engvalue;
    var $id;
    var $parent_id;
    var $classificatorid;
    var $values = array();
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


    public function __construct7($rusvalue, $engvalue, $id, $parent_id, $classificatorid, $level, $path)
    {
        $this->setID($id);
        $this->setRusName($rusvalue);
        $this->setEngName($engvalue);
        $this->setParentID($parent_id);
        $this->setLevel($level);
        $this->setPath($path);
        $this->setClassificatorid($classificatorid);
    }

    public function echoValues()
    {
        foreach ($this->values as $value) {
            echo $value->getPath();
            echo '<br>';
            $value->echoValues;
        }
    }


    /**
     * @param mixed $calssificatorid
     */
    public function setClassificatorid($calssificatorid)
    {
        $this->classificatorid = $calssificatorid;
    }

    /**
     * @return mixed
     */
    public function getClassificatorid()
    {
        return $this->classificatorid;
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

    public function setRusName($rusvalue)
    {
        $this->rusvalue = $rusvalue;
    }

    public function setEngName($engvalue)
    {
        $this->engvalue = $engvalue;
    }

    public function setValues($values)
    {
        $this->values = $values;
    }

    public function getRusName()
    {
        return $this->rusvalue;
    }

    public function getEngName()
    {
        return $this->engvalue;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getParentID()
    {
        return $this->parent_id;
    }

    public function print_view()
    {
        return 'id = ' . $this->getID() .
        ',engname=' . $this->getEngName() .
        ',rusname=' . $this->getRusName() .
        ',parent_id=' . $this->getParentID() .
        ',level=' . $this->getLevel() .
        ',path=' . $this->getPath() . ("<br>");
    }

    public function addValue($Value)
    {
        $this->values[] = $Value;
    }
}

?>

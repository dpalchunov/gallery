<?php
class  Classificator
{

    var $rusname;
    var $engname;
    var $id;
    var $values;


    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }


    public function __construct3($rusname, $engname, $id)
    {
        $this->setID($id);
        $this->setRusName($rusname);
        $this->setEngName($engname);
        $this->setValues(array());
    }

    public function setID($id)
    {
        $this->id = $id;

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

    public function print_view()
    {
        return 'id = ' . $this->getID() .
        ',engname=' . $this->getEngName() .
        ',rusname=' . $this->getRusName() . trim("<br>");
    }
}

?>

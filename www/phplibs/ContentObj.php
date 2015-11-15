<?php
class  ContentObj
{

    var $id;
    var $value;

    public function setID($id) { $this->id = $id;}
    public function getID() {return $this->id;}
    public function setValue($value) { $this->value = $value;}
    public function getValue() {return $this->value;}


    function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this, $f = '__construct' . $i)) {
            call_user_func_array(array($this, $f), $a);
        }
    }


    public function __construct2($id,$value)
    {

        $this->setID($id);
        $this->setValue($value);
    }






}

?>

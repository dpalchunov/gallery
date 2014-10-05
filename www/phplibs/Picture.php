<?php
  class  Picture {   
    var $picsFolder = 'images/gallary/';
    var $sketchesFolder = 'images/gallary/sketches/';
    var $sketchPath;
    var $picPath;
    var $rate;    
    var $position;
    var $multilangDescription;
    var $fileName;


    function __construct()
    {
      $a = func_get_args();
      $i = func_num_args();
      if (method_exists($this,$f='__construct'.$i)) {
          call_user_func_array(array($this,$f),$a);
      }
    }


    public  function __construct1($fileName) {
        $position = 0;
        $rate = 2;
        $multilangDescription = array('rus' => '', 'eng' => '');

        $this->setfileName($fileName);
        $picPath = $this -> generatePicPath();
        $sketchPath = $this -> generateSketchPath();
        $this->setPicPath($picPath);
        $this->setSketchPath($sketchPath);
        $this->setRate($rate);
        $this->setPosition($position);
        $this->setMultilangDescription($multilangDescription);
    }



    public  function __construct6($fileName, $position, $rate,
                                 $multilangDescription,
                                 $picPath, $sketchPath) {
        $this->setfileName($fileName);
        $this->setPicPath($picPath);
        $this->setSketchPath($sketchPath);
        $this->setRate($rate);
        $this->setPosition($position);
        $this->setMultilangDescription($multilangDescription);
    }


    private function generatePicPath() {
        $res = $this -> picsFolder . $this -> fileName;
        return  $res;
    }

    private function generateSketchPath() {
        $res = $this -> sketchesFolder . $this -> fileName;
        return $res;
    }
    public function setPicPath($path) {
        $this -> picPath = $path;
    }
      public function setSketchPath($path) {
          $this -> sketchPath = $path;
      }
    public function setRate($rate) {
        $this -> rate = $rate;            
    }    
    public function setMultilangDescription($desc) {
        $this -> multilangDescription = $desc;            
    }    
    public function setPosition($position) {
        $this -> position = $position;
         
    }
    public function setFileName($fileName) {
      $this -> fileName = $fileName;

    }
    public function getPicPath() {
        return $this -> picPath;
    }
    public function getSketchPath() {
      return $this -> sketchPath;
    }
    public function getRate() {
        return $this -> rate;            
    }
    public function getPosition() {
        return $this -> position;
    }
    public function getDescription($lang) {
        return $this -> multilangDescription[$lang];            
    }
    public function getMultilangDescription() {
        return $this -> multilangDescription;
    }
    public function getFileName() {
        return $this -> fileName;
    }

  }
  
?>

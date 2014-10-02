<?php
  class  Picture {   
    var $sketchPath;
    var $picPath;
    var $rate;    
    var $position;
    var $multilangDescription;
    var $fileName;

    public  function __construct($fileName, $position = 0, $rate = 2,
                                 $multilangDescription = array('rus' => '', 'eng' => ''),
                                 $picPath = '', $sketchPath = '') {
      $this->setfileName($fileName);
      $this->setPicPath($picPath);
      $this->setSketchPath($sketchPath);
      $this->setRate($rate);
      $this->setPosition($position);
      $this->setMultilangDescription($multilangDescription);
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
        $this -> sequenceNumber = $position;
         
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
    public function getFileName() {
        return $this -> fileName;
    }

  }
  
?>

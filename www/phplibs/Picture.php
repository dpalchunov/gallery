<?php
  class  Picture {   
    var $path;
    var $rate;    
    var $sequenceNumber;
    var $multilangDescription;

    public  function __construct($path, $sequenceNumber, $multilangDescription,$rate) {
        $this->setPath($path);
        $this->setRate($rate);        
        $this->setSequenceNumber($sequenceNumber);
        $this->setMultilangDescription($multilangDescription);         
    }
    public function setPath($path) {
        $this -> path = $path;            
    }
    public function setRate($rate) {
        $this -> rate = $rate;            
    }    
    public function setMultilangDescription($desc) {
        $this -> multilangDescription = $desc;            
    }    
    public function setSequenceNumber($sequenceNumber) {
        $this -> sequenceNumber = $sequenceNumber;
         
    }
    public function getPath() {
        return $this -> path;            
    }
    public function getRate() {
        return $this -> rate;            
    }
    public function getSequenceNumber() {
        return $this -> sequenceNumber;            
    }
    public function getDescription($lang) {
        return $this -> multilangDescription[$lang];            
    }    
    
  }
  
?>

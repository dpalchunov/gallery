
<?php   
  require_once 'phplibs/ResourceService.php';

  class  ClassificatorsGetter {
    private static $template_engine;
    private static $db; 

    public  function __construct() {
      global $template_engine, $db;
      $resourceService = new ResourceService();
      $template_engine = $resourceService->getTemplateEngine(); 
      $db              = $resourceService->getDBConnection(); 
    }

    
    private function getClassifiactor_html_code($classificatorText, $classificatorID) {
      return $classificatorText . "<br>\n" . $this->getClassificatorValuesHtmlCode($classificatorID) . "<br>\n";      
    }
    private function getClassificatorValuesHtmlCode($classificatorID) {
      global $db;
      if ($result = $db->query("select * from tclassificatorvalues where parentclassificatorvalueid is null  and classificatorid =" . $classificatorID)) {
        $classificatorValuesHtmlCode = '';
        $indent = $this -> getIndent(1);
        while ($row = $result->fetch_assoc()) {          
          $classificatorValuesHtmlCode .= $indent . $this->getClassificatorValueHtmlCode(2,$classificatorID, NULL, $row["classificatorvalueid"], $row["value"]) . "\n";      
        }
        return $classificatorValuesHtmlCode;
      }      
    }

    private static function getIndent($level) {     
      $indent = '';
      for ($i=0;$i<$level;$i++) {
        $indent .= '&nbsp&nbsp';
      }
      return $indent;
    }  
    private function makeClassificatorValueNameByID($id) {
      return "classificatorValue_" . $id; 
    }
    private function getClassificatorValueHtmlCode($level, $classificatorID, $parentid, $id,$text) {
      global $db,$template_engine;
      $template_engine->assign('checkbox_name', "classificatorValue_" . $id);    
      $template_engine->assign('checkbox_text', $text);
      if (isset($parentid)) {
        $template_engine->assign('parent_name', $this->makeClassificatorValueNameByID($parentid));          
      } else {
        $template_engine->assign('parent_name', '');        
      }
      $classificatorValueHtmlCode =   $template_engine->fetch('checkbox.tpl');
      if ($result = $db->query("select * from tclassificatorvalues where parentclassificatorvalueid  = " . $id . " and classificatorid=" . $classificatorID)) {
        $indent = $this->getIndent($level);
        while ($row = $result->fetch_assoc()) {      
          $classificatorValueHtmlCode .= $indent . $this->getClassificatorValueHtmlCode($level + 1,$classificatorID, $id, $row["classificatorvalueid"], $row["value"]);  
        }
        return $classificatorValueHtmlCode;
      }
    }   
    //возвращает HTML код классификаторов картин
    public function getHTMLCode() {
      global $db,$template_engine;
      if ($result = $db->query("select * from tclassificators")) {  
        $classifiactors_html_code = '';
        while ($row = $result->fetch_assoc()) {
          $classifiactors_html_code .= $this->getClassifiactor_html_code($row["name"], $row["classificatorid"]) . "<br>\n";      
        }
        $template_engine->assign('html_body',$classifiactors_html_code);
        $template_engine->display('filter_html.tpl');
        /* free result set */
        $result->free();
      }      
    }
  }
  $classificatorsGetter = new ClassificatorsGetter();
  echo $classificatorsGetter->getHTMLCode();
?>
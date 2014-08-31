
<?php   
  require_once 'phplibs/ResourceService.php';

  class  ClassificatorsGetter {
    private static $template_engine;
    private static $db;
    private static $lang;     

    public  function __construct($language) {
      global $template_engine, $db, $lang;
      $resourceService = new ResourceService();
      $template_engine = $resourceService->getTemplateEngine(); 
      $db              = $resourceService->getDBConnection();
      $lang = $language;
    }

    
    private function getClassifiactor_html_code($classificatorName, $classificatorID) {
      global $template_engine;
      $template_engine->assign('classificatorName',$classificatorName); 
      $template_engine->assign('classificatorID',$classificatorID);      
      $template_engine->assign('classificatorBody',$this->getClassificatorValuesHtmlCode($classificatorID) . "\n");      
      $classificatorHtml = $template_engine->fetch('classificator.tpl');
      return $classificatorHtml;      
    }
    private function getClassificatorValuesHtmlCode($classificatorID) {
      global $db,$template_engine,$lang;
      if ($result = $db->query("select * from tclassificatorvalues where parentclassificatorvalueid is null  and classificatorid = " . $classificatorID)) {
        $classificatorValuesHtmlCode = '';
        while ($row = $result->fetch_assoc()) {
          $multilangValue = array (                 
            'rus' => $row["rusvalue"],  
            'eng' => $row["engvalue"]
          );          
          $classificatorValuesHtmlCode .=   $this->getClassificatorValueHtmlCode(0,$classificatorID, NULL, $row["classificatorvalueid"], $multilangValue[$lang]) . "\n";      
        }
        return $classificatorValuesHtmlCode;
      }      
    }

    private static function getIndent($level,$classificatorID) {     
      $indent = '';
      for ($i=0;$i<$level+1;$i++) {
        $indent .= '<div class="checkboxIndent" classificator_id="'. $classificatorID .'"></div>';
      }
      return $indent;
    }  
    private function makeClassificatorValueNameByID($id) {
      return "classificatorValue_" . $id; 
    }
    private function getClassificatorValueHtmlCode($level, $classificatorID, $parentid, $id,$text) {
      global $db,$template_engine,$lang;
      $template_engine->assign('checkbox_name', "classificatorValue_" . $id);    
      $template_engine->assign('checkbox_text', $text);
      if (isset($parentid)) {
        $template_engine->assign('parent_name', $this->makeClassificatorValueNameByID($parentid));          
      } else {
        $template_engine->assign('parent_name', '');        
      }
      $template_engine->assign('classificatorID', $classificatorID);      
      $indents = $this->getIndent($level,$classificatorID);
      $template_engine->assign('indents', $indents); 
      $classificatorValueHtmlCode =   $template_engine->fetch('checkbox.tpl');
      if ($result = $db->query("select * from tclassificatorvalues where parentclassificatorvalueid  = " . $id . " and classificatorid= " . $classificatorID)) {
        
        while ($row = $result->fetch_assoc()) {
          $multilangValue = array (                 
            'rus' => $row["rusvalue"],  
            'eng' => $row["engvalue"]
          );            
          $classificatorValueHtmlCode .=  $this->getClassificatorValueHtmlCode($level + 1,$classificatorID, $id, $row["classificatorvalueid"], $multilangValue[$lang]);  
        }
        return $classificatorValueHtmlCode;
      }
    }   
    //возвращает HTML код классификаторов картин
    public function getHTMLCode() {
      global $db,$template_engine,$lang;
      if ($result = $db->query("select * from tclassificators")) {  
        $classifiactors_html_code = '';
        while ($row = $result->fetch_assoc()) {
          $multilangName = array (                 
            'rus' => $row["rusname"],
            'eng' => $row["engname"]
          );
          $classifiactors_html_code .= $this->getClassifiactor_html_code($multilangName[$lang], $row["classificatorid"]) . "\n<div class=classificator_divider><hr></div>";      
        }
        $template_engine->assign('html_body',$classifiactors_html_code);        
        $classificatorsHTMLCode = $template_engine->fetch('filter_html.tpl');
        /* free result set */
        $result->free();
        return $classificatorsHTMLCode;
      }      
    }
  }
//  $classificatorsGetter = new ClassificatorsGetter();
//  echo $classificatorsGetter->getHTMLCode();
?>
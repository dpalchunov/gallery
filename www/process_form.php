<?php
  require_once 'phplibs/ResourceService.php';
  class  PicturesGetter {
    
    private static $template_engine;
    private static $db; 
    const ROW_SIZE = 3; /*in pictures*/
    const PAGE_SIZE = 3; /*in rows*/

    public  function __construct() {
      global $template_engine, $db;
      $resourceService = new ResourceService();
      $template_engine = $resourceService->getTemplateEngine(); 
      $db              = $resourceService->getDBConnection(); 
    }
    public function getPicturesPageByFilterAndPageNum($filter, $pageNum) {
        global $db;
        try {
            $this -> checkFilterArray($filter);
            $whereStr = $this->makeWhereStringByFilter($filter);
            $query    = $this->makePicturesQueryByWhere($whereStr);
            if ($pictures = $db->query($query,NULL,'col')) {
//echo sizeof($pictures);
                $filteredPictures = $this->filterPicturesByPageNum($pictures, $pageNum);
//echo sizeof($filteredPictures);
                $picturesHTML = $this->getPicturesHTML($filteredPictures);

            } else {
                return '';
            }
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
        return $picturesHTML;        
    }
    private function makeWhereStringByFilter($filter) {
        $this->checkFilterArray($filter);
        $whereStr = '(' . implode(',',array_keys($filter)) . ')';
        $whereStr = str_replace('classificatorValue_','',$whereStr); 
        return $whereStr;
    }
    //в фильтре могут быть только пары
    //                                 classificatoValue_[ID] -> on
    //если что-то другое - exception, это может быть и SQL Injection
    private function checkFilterArray($filter){
        $array_keys = array_keys($filter);     
        foreach ($array_keys as $key) {
            $key = str_replace('classificatorValue_','',$key);
            if (!is_int((int)$key)) {
                throw new Exception("Classificators values are not integers, or wrong input format.");
            }
        }    
    }
    private function makePicturesQueryByWhere($whereStr) {
        global $db;
        $query = 'select p.picturepath, count(c.classificatorid) passedclassificators 
                    from 
                      tclassificatorvalues cv
                        inner join tclassificators c
                                    on c.classificatorid = cv.classificatorid
                            inner join tpictureclassificatorvaluerelations pcr
                                    on pcr.classificatorvalueid = cv.classificatorvalueid
                            inner join tpictures p 
                                    on p.pictureid = pcr.pictureid
                    where cv.classificatorvalueid in {classificator_values} 
                    group by p.picturepath
                    /*берем только те картины, у которых количество классификаторов в которые они вошли равно количеству классификаторов, используемых пользователем*/
                    /*passedclassificators - колчество классификаторов в которые вошла картинка  */
                    /*подзаспрос - количеству классификаторов, используемых пользователем  */
                    having passedclassificators = (select count(classificators.classificatorid) from
                                                                    (select distinct(classificatorid) classificatorid 
                                                                    from tclassificatorvalues 
                                                                    where classificatorvalueid in {classificator_values}) classificators)';
        $query = str_replace('{CLASSIFICATOR_VALUES}',$whereStr,$query);
        return $query;
    }
  
    private function filterPicturesByPageNum($pictures, $pageNum) {
//echo 'rowSize ' . self::ROW_SIZE;
//echo '$pageSize ' . self::PAGE_SIZE; 
      
      $pageSizeInPictures = self::ROW_SIZE*self::PAGE_SIZE;
      $pictureFrom = $pageSizeInPictures*($pageNum-1);
//echo 'pictures from ' . $pictureFrom;      

      $pictureTo = $pictureFrom + $pageSizeInPictures - 1;
//echo 'pageSizeInPictures  ' . $pageSizeInPictures;
//echo 'pictures to ' . $pictureTo . ' ';
      if (count($pictures) >= $pictureTo) {
          $start = $pictureFrom;
          $offset = $pageSizeInPictures;
          $pictures = array_slice($pictures,$start,$offset);    
      } else {
          if (count($pictures) >= $pictureFrom) {
              $start = $pictureFrom;
              $offset = count($pictures) - $pictureFrom;
              $pictures = array_slice($pictures,$start,$offset);
          } else {
              $pictures = array();
          }
      }    
      return $pictures;  
    } 
  
    private function getPicturesHTML ($pictures) {
        global $template_engine;
        if (!(sizeof($pictures) > 0)) { return ''; };
        $fullRowsCount = $this -> getFullRowsCount($pictures);
        $lastRowPicCount = $this -> getLastRowPicCount($pictures);        
        $pictureRows = '';
        //сначала все полные строки
        for ($row = 0;$row < $fullRowsCount; $row++) {
            $pictureRow = $this -> getPictureRowHtmlCode($pictures, $row);                    
            $pictureRows .= $pictureRow . $this -> getEmptyPictureRowHtmlCode();
        }
        //последнюю неполную строку
        $pictureRow = $this -> getPictureRowHtmlCode($pictures, $row, $lastRowPicCount);                    
        $pictureRows .= $pictureRow . $this -> getEmptyPictureRowHtmlCode();               
        return $pictureRows;
    }
    
    
    private function getFullRowsCount ($pictures) {
        $fullRowsCount = intval(sizeof($pictures) / self::ROW_SIZE);
//echo sizeof($pictures) . ' ';

//echo $fullRowsCount . ' ';
        return $fullRowsCount;
    }
    
    private function getLastRowPicCount ($pictures) {
        $fullRowsCount = $this -> getFullRowsCount($pictures);
        $lastRowPicCount = (sizeof($pictures) - ($fullRowsCount*self::ROW_SIZE));
//echo $lastRowPicCount . ' ';
        return $lastRowPicCount;

    }    
    private function getPictureRowHtmlCode($pictures, $rowNum, $picturesCountInRow = self::ROW_SIZE) {
        global $template_engine;    
        $picturesInRow = '';
        for ($pic = 0;$pic < $picturesCountInRow ;$pic++) {
//echo $rowNum . ' ' . $pic . '<br>';


//echo self::ROW_SIZE*($rowNum)+$pic . ' ';
            $picture = $this->getPicHTMLCode($pictures[self::ROW_SIZE*($rowNum)+$pic]);
            $picturesInRow .= $picture;
        }
        $template_engine->assign('class',''); 
        $template_engine->assign('pictures',$picturesInRow);
        $pictureRow = $template_engine->fetch('tr.tpl');                     
        return $pictureRow;
    }
    
    private function getEmptyPictureRowHtmlCode () {
        global $template_engine;
        $template_engine->assign('class', 'separate_row');
        $emptyPictureRowHtmlCode = $template_engine->fetch('tr.tpl'); 
    }
    
    private function getPicHTMLCode($picture){
        global $template_engine;
//echo $picture . ' ';
        $template_engine->assign('pictureNum', $picture);
        $picHTMLCode = $template_engine -> fetch('td.tpl');
        return $picHTMLCode;     
        $classificatorValueHtmlCode = $template_engine->fetch('checkbox.tpl');
    }
  }  
  $picturesGetter = new PicturesGetter();
  echo $picturesGetter->getPicturesPageByFilterAndPageNum($_POST,3);

?>
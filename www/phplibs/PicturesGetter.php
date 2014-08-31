<?php
  require_once 'phplibs/ResourceService.php';
  class  PicturesGetter {
    
    private static $template_engine;
    private static $db;
    private static $lang;      
    const ROW_SIZE = 3; /*in pictures*/
    const PAGE_SIZE = 3; /*in rows*/

    public  function __construct($language) {
      global $template_engine, $db, $lang;
      $resourceService = new ResourceService();
      $template_engine = $resourceService->getTemplateEngine(); 
      $db              = $resourceService->getDBConnection();
      $lang = $language;      
    }
    
  /*  public  function __destruct() {
        global $db;
        $db->disconnect();    
    }   */

    public function getFullScreenGalleryPicture($filter, $num) {
        $pictureObjectArray = $this -> getNotfilteredPicturesArray($filter);
        if ($pictureObjectArray != null) {
            $pictureObject =  $pictureObjectArray[$num-1]; 
            $picturesHTML = $this->getFullScreenPictureHTML($pictureObject);
            return $picturesHTML; 
        } else {
            return '';
        }          
    }
    
     public function getPicturesCountByFilter($filter){
        global $db;
        $query =  $this -> makeQuery($filter);
        try {
            if ($pictures = $db->query($query,NULL,'col')) {
                return  sizeof($pictures);
            } else {
                return 0;
            }
        }
        catch(Exception $e) {
            echo $e->getMessage();
            return 0;
        }         
     }
    

    
    public function getPicturesPageByFilterAndPageNum($filter, $pageNum, $lang) {
        $pictureObjectArray = $this -> getNotfilteredPicturesArray($filter);
        if ($pictureObjectArray != null) {
            $filteredPictureObjectArray = $this->filterPicturesByPageNum($pictureObjectArray, $pageNum);
            $picturesHTML =     $this->getPicturesHTML($filteredPictureObjectArray, $lang);
            return $picturesHTML; 
        } else {
            return '';
        }              
    }
    
        
   
    private function getNotfilteredPicturesArray($filter){
        global $db;
        $query =  $this -> makeQuery($filter);
        try {
            $pictureObjectArray =  array();
            if ($pictures = $db->query($query,NULL,'assoc')) {
                $i = 0;
                foreach ($pictures as $picture) {
                    $picPath = $picture['picturepath'];
                    $rusDesc = $picture['rusdesc'];
                    $engDesc = $picture['engdesc'];                 
                    $rate = $picture['rate'];
                    $multilangDesc = array (                 
                      'rus' => $rusDesc,
                      'eng' => $engDesc
                    );
                    //echo $multilangDesc; 
                    $pictureObject = new Picture($picPath,$i,$multilangDesc,$rate);
                    $pictureObjectArray[$i] = $pictureObject;
                    $i++;
                }
                return  $pictureObjectArray;
            } else {
                return null;
            }
        }
        catch(Exception $e) {
            echo $e->getMessage();
            return null;
        }        
    }
    private function makeQuery($filter) {
        $this -> checkFilterArray($filter);
        $whereStr = $this->makeWhereStringByFilter($filter);
        $query    = $this->makePicturesQueryByWhere($whereStr);
        return $query;    
    }
    
    private function makeWhereStringByFilter($filter) {
        if (sizeof($filter) > 0) {
            $whereStr = '(' . implode(',',array_keys($filter)) . ')';
            $whereStr = str_replace('classificatorValue_','',$whereStr); 
        } else {
            $whereStr = '';
        }
        return $whereStr;
    }
    //в фильтре могут быть только пары
    //                                 classificatoValue_[ID] -> on
    //если что-то другое - exception, это может быть и SQL Injection
    private function checkFilterArray($filter){
        $array_keys = array_keys($filter);     
        foreach ($array_keys as $key) {
            $key = str_replace('classificatorValue_','',$key);
            if (!is_numeric($key)) {
                throw new Exception("Classificators values are not integers, or input format is wrong.");
            }
        }    
    }
    private function makePicturesQueryByWhere($whereStr) {
        global $db;
        if ($whereStr != '') {
            $query = 'select p.picturepath,p.rusdesc,p.engdesc,p.rate, count(c.classificatorid) passedclassificators 
                        from 
                          tclassificatorvalues cv
                            inner join tclassificators c
                                        on c.classificatorid = cv.classificatorid
                                inner join tpictureclassificatorvaluerelations pcr
                                        on pcr.classificatorvalueid = cv.classificatorvalueid
                                inner join tpictures p 
                                        on p.pictureid = pcr.pictureid
                        where cv.classificatorvalueid in {CLASSIFICATOR_VALUES} 
                        group by p.picturepath,p.rusdesc,p.engdesc,p.rate
                        /*берем только те картины, у которых количество классификаторов в которые они вошли равно количеству классификаторов, используемых пользователем*/
                        /*passedclassificators - колчество классификаторов в которые вошла картинка  */
                        /*подзаспрос - количеству классификаторов, используемых пользователем  */
                        having passedclassificators = (select count(classificators.classificatorid) from
                                                                        (select distinct(classificatorid) classificatorid 
                                                                        from tclassificatorvalues 
                                                                        where classificatorvalueid in {CLASSIFICATOR_VALUES}) classificators)';
            $query = str_replace('{CLASSIFICATOR_VALUES}',$whereStr,$query);
        } else {
            $query = 'select p.picturepath, p.rusdesc,p.engdesc,p.rate from tpictures p';    
        }
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
              $pictures = null;
          }
      }    
      return $pictures;  
    } 
  
    private function getPicturesHTML ($pictures, $lang) {
        global $template_engine;
        if (!(sizeof($pictures) > 0)) { return ''; };
        $fullRowsCount = $this -> getFullRowsCount($pictures);
      
        $pictureRows = '';
        //сначала все полные строки
        for ($row = 0;$row < $fullRowsCount; $row++) {
            $pictureRow = $this -> getPictureRowHtmlCode($lang, $pictures, $row);                    
            $pictureRows .= $pictureRow . $this -> getEmptyPictureRowHtmlCode();
        }
        $filledRowsCount = $this -> getFilledRowsCount($pictures);
        if ($filledRowsCount > $fullRowsCount) {
            $lastRowPicCount = $this -> getLastRowPicCount($pictures);  
            //последнюю неполную строку
            $pictureRow = $this -> getPictureRowHtmlCode($lang ,$pictures, $fullRowsCount, $lastRowPicCount);                    
            $pictureRows .= $pictureRow . $this -> getEmptyPictureRowHtmlCode();               
          
        }
        return $pictureRows;          
    }
    
    
    private function getFullRowsCount ($pictures) {
        $fullRowsCount = intval(sizeof($pictures) / self::ROW_SIZE);
//echo sizeof($pictures) . ' ';

//echo $fullRowsCount . ' ';
        return $fullRowsCount;
    }

    private function getFilledRowsCount ($pictures) {
        $fullRowsCount = intval(sizeof($pictures) / self::ROW_SIZE);
        if ($fullRowsCount == (sizeof($pictures) / self::ROW_SIZE)) {
            return $fullRowsCount;
        } else {
            return $fullRowsCount + 1;            
        }

    }    
    
    
    private function getLastRowPicCount ($pictures) {
        $fullRowsCount = $this -> getFullRowsCount($pictures);
        $lastRowPicCount = (sizeof($pictures) - ($fullRowsCount*self::ROW_SIZE));
//echo $lastRowPicCount . ' ';
        return $lastRowPicCount;

    }    
    private function getPictureRowHtmlCode($lang, $pictures, $rowNum, $picturesCountInRow = self::ROW_SIZE) {
        global $template_engine;    
        $picturesInRow = '';
        for ($pic = 0;$pic < $picturesCountInRow ;$pic++) {
//echo $rowNum . ' ' . $pic . '<br>';


//echo self::ROW_SIZE*($rowNum)+$pic . ' ';
            $sequenceNumberInsidePage = self::ROW_SIZE*($rowNum)+$pic;
            $pictureObject = $pictures[$sequenceNumberInsidePage];
            $picture = $this-> getPicHTMLCode($pictureObject, $lang);
            $picturesInRow .= $picture;
        }
        $template_engine->assign('row_class','ordinary_row'); 
        $template_engine->assign('pictures',$picturesInRow);
        $pictureRow = $template_engine->fetch('tr.tpl');                     
        return $pictureRow;
    }
    
    private function getEmptyPictureRowHtmlCode () {
        global $template_engine;
        $template_engine->assign('row_class', 'separate_row');
        $emptyRowContent = '';
        for ($i=0;$i<self::ROW_SIZE;$i++) {
            $emptyRowContent .= '<td></td>';    
        }
        $template_engine->assign('pictures',$emptyRowContent);
        $emptyPictureRowHtmlCode = $template_engine->fetch('tr.tpl');
        return $emptyPictureRowHtmlCode;
    }
    
    private function getPicHTMLCode($pictureObject, $lang){
        global $template_engine;
//echo $picture . ' ';
        
        $picturePath = $pictureObject -> getPath();
        $pictureSequenceNumber = $pictureObject -> getSequenceNumber() + 1;
        $picDescription = $pictureObject -> getDescription($lang);
        $picRate = $pictureObject -> getRate();
        $picRateHtml = $this-> makePicRateHtml($picRate);
        $template_engine->assign('picRate', $picRateHtml);        
        $template_engine->assign('picDescription', $picDescription);        
        $template_engine->assign('pictureNum', $picturePath);
        $template_engine->assign('sequenceNumber', $pictureSequenceNumber);        
        $picHTMLCode = $template_engine -> fetch('td.tpl');
        return $picHTMLCode;     
//        $classificatorValueHtmlCode = $template_engine->fetch('checkbox.tpl');
    }
    
    private function makePicRateHtml($picRate) {
      return str_repeat('<img class="rate_star" align="right" src="images/gallary/star.png"/>',$picRate);
    }
    private function makeFullScreenPicRateHtml($picRate) {
      return str_repeat('<img class="rate_star" align="right" src="images/gallary/star_32.png"/>',$picRate);
    }    
    private function getFullScreenPictureHTML($pictureObject){
        global $template_engine, $lang;        
        $picture = $pictureObject -> getPath();        
        $picDescription = $pictureObject -> getDescription($lang);
        $picRate = $pictureObject -> getRate();
        $picRateHtml = $this-> makeFullScreenPicRateHtml($picRate);
        $template_engine->assign('pictureName', $picture);
        $template_engine->assign('fullScreenPicRate', $picRateHtml);
        $template_engine->assign('fullScreenPicDetails', $picDescription);        
        $picHTMLCode = $template_engine -> fetch('fullscreengallery_pic.tpl');
        return $picHTMLCode;                
    }   

  }  
?>
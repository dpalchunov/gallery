<?php
require_once 'phplibs/ResourceService.php';
class  PicturesGetter
{

    private static $template_engine;
    private static $db;
    private static $lang;
    const ROW_SIZE = 3; /*in pictures*/
    const PAGE_SIZE = 3; /*in rows*/

    public function __construct($language)
    {
        global $template_engine, $db, $lang;
        $resourceService = new ResourceService();
        $template_engine = $resourceService->getTemplateEngine();
        $db = $resourceService->getDBConnection();
        $lang = $language;
    }

    /*  public  function __destruct() {
          global $db;
          $db->disconnect();
      }   */


    public function getFullScreenGalleryPicture($filter, $num)
    {
        $pictureObjectArray = $this->getNotfilteredPicturesArray($filter);
        if ($pictureObjectArray != null) {
            $pictureObject = $pictureObjectArray[$num - 1];
            $picturesHTML = $this->getFullScreenPictureHTML($pictureObject);
            return $picturesHTML;
        } else {
            return '';
        }
    }

    public function getPicturesCountByFilter($filter)
    {
        global $db;
        $query = $this->makeQuery($filter);
        try {
            if ($pictures = $db->query($query, NULL, 'col')) {
                return sizeof($pictures);
            } else {
                return 0;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return 0;
        }
    }


    public function getPicturesPageByFilterAndPageNum($filter, $pageNum, $lang)
    {
        $pictureObjectArray = $this->getNotfilteredPicturesArray($filter);
        if ($pictureObjectArray != null) {
            $filteredPictureObjectArray = $this->filterPicturesByPageNum($pictureObjectArray, $pageNum);
            $picturesHTML = $this->getPicturesHTML($filteredPictureObjectArray, $lang);
            return $picturesHTML;
        } else {
            return '';
        }
    }

// refactor : use picture manager instead
    private function getNotfilteredPicturesArray($filter)
    {
        global $db;
        $query = $this->makeQuery($filter);
        try {
            $pictureObjectArray = array();
            if ($pictures = $db->query($query, NULL, 'assoc')) {
                $i = 0;
                foreach ($pictures as $picture) {
                    $pictureID = $picture['pictureid'];
                    $fileName = $picture['file_name'];
                    $sketchPath = $picture['sketch_path'];
                    $picPath = $picture['pic_path'];
                    $thumbnail = $picture['thumbnail'];
                    $rusDesc = $picture['rusdesc'];
                    $engDesc = $picture['engdesc'];
                    $rate = $picture['rate'];
                    $multilangDesc = array(
                        'rus' => $rusDesc,
                        'eng' => $engDesc
                    );
                    //echo $multilangDesc;
                    $pictureObject = new Picture($fileName, $i, $rate, $multilangDesc, $picPath, $sketchPath, $thumbnail, $pictureID);

                    $pictureObjectArray[$i] = $pictureObject;
                    $i++;
                }
                return $pictureObjectArray;
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function makeQuery($filter)
    {
        $this->checkFilterArray($filter);
        $whereStr = $this->makeWhereStringByFilter($filter);
        $query = $this->makePicturesQueryByWhere($whereStr);
        return $query;
    }

    private function makeWhereStringByFilter($filter)
    {
        if (sizeof($filter) > 0) {
            $whereStr = '(' . implode(',', array_keys($filter)) . ')';
            $whereStr = str_replace('classificatorValue_', '', $whereStr);
        } else {
            $whereStr = '';
        }
        return $whereStr;
    }

    //в фильтре могут быть только пары
    //                                 classificatoValue_[ID] -> on
    //если что-то другое - exception, это может быть и SQL Injection
    private function checkFilterArray($filter)
    {
        $array_keys = array_keys($filter);
        foreach ($array_keys as $key) {
            $key = str_replace('classificatorValue_', '', $key);
            if (!is_numeric($key)) {
                throw new Exception("Classificators values are not integers, or input format is wrong.");
            }
        }
    }

    private function makePicturesQueryByWhere($whereStr)
    {
        global $db;
        if ($whereStr != '') {
            $query = 'SELECT p.file_name,p.position, p.sketch_path,p.pic_path,p.thumbnail, p.rusdesc,p.engdesc,p.rate, count(c.classificatorid) passedclassificators
                        FROM
                          tclassificatorvalues cv
                            INNER JOIN tclassificators c
                                        ON c.classificatorid = cv.classificatorid
                                INNER JOIN tpictureclassificatorvaluerelations pcr
                                        ON pcr.classificatorvalueid = cv.classificatorvalueid
                                INNER JOIN tpictures p
                                        ON p.pictureid = pcr.pictureid
                        WHERE cv.classificatorvalueid IN {CLASSIFICATOR_VALUES}
                        GROUP BY p.file_name,p.position,p.sketch_path,p.pic_path,p.thumbnail,p.rusdesc,p.engdesc,p.rate
                        /*берем только те картины, у которых количество классификаторов в которые они вошли равно количеству классификаторов, используемых пользователем*/
                        /*passedclassificators - колчество классификаторов в которые вошла картинка  */
                        /*подзаспрос - количеству классификаторов, используемых пользователем  */
                        HAVING passedclassificators = (SELECT COUNT(classificators.classificatorid) FROM
                                                                        (SELECT DISTINCT(classificatorid) classificatorid
                                                                        FROM tclassificatorvalues
                                                                        WHERE classificatorvalueid IN {CLASSIFICATOR_VALUES}) classificators)
                        ORDER BY position';
            $query = str_replace('{CLASSIFICATOR_VALUES}', $whereStr, $query);
        } else {
            $query = 'SELECT p.file_name,p.position,p.sketch_path,p.pic_path,p.thumbnail, p.rusdesc,p.engdesc,p.rate FROM tpictures p ORDER BY position';
        }
        return $query;
    }

    private function filterPicturesByPageNum($pictures, $pageNum)
    {
//echo 'rowSize ' . self::ROW_SIZE;
//echo '$pageSize ' . self::PAGE_SIZE; 

        $pageSizeInPictures = self::ROW_SIZE * self::PAGE_SIZE;
        $pictureFrom = $pageSizeInPictures * ($pageNum - 1);
//echo 'pictures from ' . $pictureFrom;      

        $pictureTo = $pictureFrom + $pageSizeInPictures - 1;
//echo 'pageSizeInPictures  ' . $pageSizeInPictures;
//echo 'pictures to ' . $pictureTo . ' ';
        if (count($pictures) >= $pictureTo) {
            $start = $pictureFrom;
            $offset = $pageSizeInPictures;
            $pictures = array_slice($pictures, $start, $offset);
        } else {
            if (count($pictures) >= $pictureFrom) {
                $start = $pictureFrom;
                $offset = count($pictures) - $pictureFrom;
                $pictures = array_slice($pictures, $start, $offset);
            } else {
                $pictures = null;
            }
        }
        return $pictures;
    }

    private function getPicturesHTML($pictures, $lang)
    {
        global $template_engine;
        if (!(sizeof($pictures) > 0)) {
            return '';
        };
        $fullRowsCount = $this->getFullRowsCount($pictures);

        $pictureRows = '';
        //сначала все полные строки
        for ($row = 0; $row < $fullRowsCount; $row++) {
            $pictureRow = $this->getPictureRowHtmlCode($lang, $pictures, $row);
            $pictureRows .= $pictureRow . $this->getEmptyPictureRowHtmlCode();
        }
        $filledRowsCount = $this->getFilledRowsCount($pictures);
        if ($filledRowsCount > $fullRowsCount) {
            $lastRowPicCount = $this->getLastRowPicCount($pictures);
            //последнюю неполную строку
            $pictureRow = $this->getPictureRowHtmlCode($lang, $pictures, $fullRowsCount, $lastRowPicCount);
            $pictureRows .= $pictureRow . $this->getEmptyPictureRowHtmlCode();

        }
        return $pictureRows;
    }


    private function getFullRowsCount($pictures)
    {
        $fullRowsCount = intval(sizeof($pictures) / self::ROW_SIZE);
//echo sizeof($pictures) . ' ';

//echo $fullRowsCount . ' ';
        return $fullRowsCount;
    }

    private function getFilledRowsCount($pictures)
    {
        $fullRowsCount = intval(sizeof($pictures) / self::ROW_SIZE);
        if ($fullRowsCount == (sizeof($pictures) / self::ROW_SIZE)) {
            return $fullRowsCount;
        } else {
            return $fullRowsCount + 1;
        }

    }


    private function getLastRowPicCount($pictures)
    {
        $fullRowsCount = $this->getFullRowsCount($pictures);
        $lastRowPicCount = (sizeof($pictures) - ($fullRowsCount * self::ROW_SIZE));
//echo $lastRowPicCount . ' ';
        return $lastRowPicCount;

    }

    private function getPictureRowHtmlCode($lang, $pictures, $rowNum, $picturesCountInRow = self::ROW_SIZE)
    {
        global $template_engine;
        $picturesInRow = '';
        for ($pic = 0; $pic < $picturesCountInRow; $pic++) {
//echo $rowNum . ' ' . $pic . '<br>';


//echo self::ROW_SIZE*($rowNum)+$pic . ' ';
            $sequenceNumberInsidePage = self::ROW_SIZE * ($rowNum) + $pic;
            $pictureObject = $pictures[$sequenceNumberInsidePage];
            $picture = $this->getPicHTMLCode($pictureObject, $lang);
            $picturesInRow .= $picture;
        }
        $template_engine->assign('row_class', 'ordinary_row');
        $template_engine->assign('pictures', $picturesInRow);
        $pictureRow = $template_engine->fetch('tr.tpl');
        return $pictureRow;
    }

    private function getEmptyPictureRowHtmlCode()
    {
        global $template_engine;
        $template_engine->assign('row_class', 'separate_row');
        $emptyRowContent = '';
        for ($i = 0; $i < self::ROW_SIZE; $i++) {
            $emptyRowContent .= '<td></td>';
        }
        $template_engine->assign('pictures', $emptyRowContent);
        $emptyPictureRowHtmlCode = $template_engine->fetch('tr.tpl');
        return $emptyPictureRowHtmlCode;
    }

    private function getPicHTMLCode($pictureObject, $lang)
    {
        global $template_engine;
//echo $picture . ' ';

        $pictureFileName = $pictureObject->getFileName();
        $pictureSequenceNumber = $pictureObject->getPosition() + 1;
        $picDescription = $pictureObject->getDescription($lang);
        $picRate = $pictureObject->getRate();
        $picRateHtml = $this->makePicRateHtml($picRate);
        $template_engine->assign('picRate', $picRateHtml);
        $template_engine->assign('picDescription', $picDescription);
        $template_engine->assign('pictureFileName', $pictureFileName);
        $template_engine->assign('sequenceNumber', $pictureSequenceNumber);
        $picHTMLCode = $template_engine->fetch('td.tpl');
        return $picHTMLCode;
//        $classificatorValueHtmlCode = $template_engine->fetch('checkbox.tpl');
    }

    private function makePicRateHtml($picRate)
    {
        return str_repeat('<img class="rate_star" align="right" src="images/gallary/star.png"/>', $picRate);
    }

    private function makeFullScreenPicRateHtml($picRate)
    {
        return str_repeat('<img class="rate_star" align="right" src="images/gallary/star_32.png"/>', $picRate);
    }

    private function getFullScreenPictureHTML(Picture $pictureObject)
    {
        global $template_engine, $lang;
        $thumbnail = $pictureObject->getThumbnail();
        $picDescription = $pictureObject->getDescription($lang);
        $picRate = $pictureObject->getRate();
        $picRateHtml = $this->makeFullScreenPicRateHtml($picRate);
        $template_engine->assign('pictureName', $thumbnail);
        $template_engine->assign('fullScreenPicRate', $picRateHtml);
        $template_engine->assign('fullScreenPicDetails', $picDescription);
        $picHTMLCode = $template_engine->fetch('fullscreengallery_pic.tpl');
        return $picHTMLCode;
    }

}

?>
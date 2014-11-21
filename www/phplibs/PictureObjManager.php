<?php
require_once 'phplibs/ResourceService.php';


class PictureObjManager
{

    private static $db;

    public function __construct()
    {
        global $db;
        $resourceService = new ResourceService();
        $db = $resourceService->getDBConnection();
    }

    private function preparePicSelectPattern()
    {
        return "SELECT * FROM strunkovadb.tpictures WHERE sketch_path <> '' AND  pictureid = ?"; //den_debug remove sketch_path <> ''

    }

    private function preparePicRelSelectPattern()
    {
        return "SELECT p.pictureid,c.classificatorid AS cl_id,max(r.pictureclassificatorvaluerelationid) AS id, max(r.classificatorvalueid) AS cv_id, max(cv.path) AS path FROM
                    tclassificators c
                      INNER JOIN tpictures p ON p.pictureid = ?
                      LEFT JOIN tclassificatorvalues cv ON cv.classificatorid = c.classificatorid
                      LEFT JOIN tpictureclassificatorvaluerelations r ON r.classificatorvalueid = cv.classificatorvalueid AND r.pictureid = p.pictureid
                  GROUP BY p.pictureid, c.classificatorid";
    }

    private function preparePicRelSelectAllPattern()
    {
        return "SELECT p.pictureid,c.classificatorid AS cl_id,max(r.pictureclassificatorvaluerelationid) AS id, max(r.classificatorvalueid) AS cv_id , max(cv.path) AS path FROM
                    tclassificators c
                      INNER JOIN tpictures p
                      LEFT JOIN tclassificatorvalues cv ON cv.classificatorid = c.classificatorid
                      LEFT JOIN tpictureclassificatorvaluerelations r ON r.classificatorvalueid = cv.classificatorvalueid AND r.pictureid = p.pictureid
                  GROUP BY p.pictureid, c.classificatorid";
    }

    private function prepareSelectAllPattern()
    {
        return "SELECT * FROM strunkovadb.tpictures WHERE sketch_path <> ''"; //den_debug remove sketch_path <> ''

    }

    public function selectAllPics()
    {
        global $db;
        $pattern = $this->prepareSelectAllPattern();
        $rels_pattern = $this->preparePicRelSelectAllPattern();
        try {
            if ($pictures = $db->query($pattern, NULL, 'assoc') and $raw_rels = $db->query($rels_pattern, NULL, 'assoc')) {
                $rels = $this->transform_raw_pic_rels($raw_rels);
                return $this->toPicObjects($pictures, $rels);
            } else {
                return array();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function toPicObjects(array $pictures, array $pics_rels)
    {
        $pictureObjectArray = array();
        foreach ($pictures as $picture) {
            $pictureID = (int)$picture['pictureid'];

            $rusDesc = $picture['rusdesc'];
            $engDesc = $picture['engdesc'];

            $fileName = $picture['file_name'];
            $position = $picture['position'];
            $rate = $picture['rate'];
            $multilangDesc = array(
                'rus' => $rusDesc,
                'eng' => $engDesc
            );
            $picPath = $picture['pic_path'];
            $sketchPath = $picture['sketch_path'];

            $pic_rels = $pics_rels["p" . $pictureID];


            $pictureObject = new Picture($fileName, $position, $rate, $multilangDesc, $picPath, $sketchPath, $pictureID, $pic_rels);
            $pictureObjectArray[] = $pictureObject;
        }
        return $pictureObjectArray;
    }

    public function selectPicByID($pictureID)
    {
        global $db;
        $pic_pattern = $this->preparePicSelectPattern();
        $pic_rel_pattern = $this->preparePicRelSelectPattern();

        try {
            if ($pictures = $db->query($pic_pattern, array($pictureID), 'assoc') and $raw_pic_rels = $db->query($pic_rel_pattern, array($pictureID), 'assoc')) {
                $pic_rels = $this->transform_raw_pic_rels($raw_pic_rels);
                $res = $this->toPicObjects($pictures, $pic_rels);
                return $res[0];
            } else {
                echo 'error';
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function transform_raw_pic_rels($raw_pic_rels)
    {
        $pic_rels = array();
        foreach ($raw_pic_rels as $raw_pic_rel) {
            $pictureID = (int)$raw_pic_rel['pictureid'];
            $id = (int)$raw_pic_rel['id'];
            $cl_v_id = (int)$raw_pic_rel['cv_id'];
            $cl_id = (int)$raw_pic_rel['cl_id'];
            $path = $raw_pic_rel['path'];

            $picRel = new PicClRel($id, $pictureID, $cl_id, $cl_v_id);
            $picRel->setPath($path);
            if ($id > 0) {
                $picRel->setPersisted(true);
            }
            $pic_arr = $pic_rels["p" . $pictureID];
            if (!isset($pic_arr)) {
                $pic_arr = array();
            }
            array_push($pic_arr, $picRel);
            $pic_rels["p" . $pictureID] = $pic_arr;
        }
        return $pic_rels;
    }

    public function updatePicture(Picture $picture)
    {
        global $db;
        $pattern = $this->prepareUpdatePattern();
        $data = $this->prepareUpdateQueryData($picture);
        try {
            if ($pictures = $db->query($pattern, $data)) {
                $this->updateRelations($picture->getClassification());
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }


    public function updateRelations(array $rels)
    {
        var_dump($rels);
        foreach ($rels as $rel) {
            $id = $rel->getID();
            $rop = $rel->getRemoveOnPersist();
            //$cl_vid = $rel -> getClvlID();
            $persisted = $rel->getPersisted();
            echo ' persisted:' . $persisted . ' ';
            if ($persisted) {
                echo $id;
                if ($rop) {
                    echo '-remove ';
                    $this->removeRelation($rel);
                } else {
                    echo '-update ';
                    $this->updateRelation($rel);
                }
            } else {

                if (!$rop) {

                    echo '-insert ';
                    $this->insertRelation($rel);
                } else {
                    echo '-nothing to do  ';
                }
            }


            /*   if (is_int($id) && $id > 0) {
                   if (is_int($cl_vid) && $cl_vid > 0)  {
                       $this->updateRelation($rel);
                   }  else {
                       $this->removeRelation($rel);
                   }
               } else {
                   if (is_int($cl_vid) && $cl_vid > 0) {
                       $this->insertRelation($rel);
                   }
               }    */
        }
    }

    public function updateRelation(PicClRel $rel)
    {
        global $db;
        $pattern = $this->prepareUpdateRelPattern();
        $data = $this->prepareUpdateRelQueryData($rel);
        try {
            if ($pictures = $db->query($pattern, $data)) {
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function insertRelation(PicClRel $rel)
    {
        global $db;
        $pattern = $this->prepareInsertRelPattern();
        $data = $this->prepareInsertRelQueryData($rel);
        try {
            if ($pictures = $db->query($pattern, $data)) {
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }


    public function savePicture(Picture $picture)
    {
        global $db;
        $pattern = $this->preparePattern();
        $data = $this->prepareQueryData($picture);
        try {
            if ($pictures = $db->query($pattern, $data)) {
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function prepareQueryData(Picture $picture)
    {
        $descriptions = $picture->getMultilangDescription();
        return array($picture->getFileName(), $picture->getRate(), $descriptions['rus'], $descriptions['eng'], $picture->getPicPath(), $picture->getSketchPath(), $picture->getPosition());
    }

    private function prepareUpdateQueryData(Picture $picture)
    {
        $descriptions = $picture->getMultilangDescription();
        return array($picture->getFileName(), $picture->getRate(), $descriptions['rus'], $descriptions['eng'], $picture->getPicPath(), $picture->getSketchPath(), $picture->getPosition(), $picture->getID());
    }

    private function prepareUpdateRelQueryData(PicClRel $rel)
    {
        return array($rel->getPicID(), $rel->getClvlID(), $rel->getID());
    }

    private function prepareInsertRelQueryData(PicClRel $rel)
    {
        return array($rel->getPicID(), $rel->getClvlID());
    }

    private function preparePattern()
    {
        return "INSERT INTO strunkovadb.tpictures (file_name,rate,rusdesc,engdesc,pic_path,sketch_path,position) VALUES (?,?,?,?,?,?,?)";

    }

    private function prepareUpdatePattern()
    {
        return "UPDATE strunkovadb.tpictures SET file_name = ?,rate = ?,rusdesc = ?,engdesc = ?,pic_path = ?,sketch_path = ?,position = ? WHERE pictureid = ? ";

    }

    private function prepareUpdateRelPattern()
    {
        return "UPDATE strunkovadb.tpictureclassificatorvaluerelations SET pictureid = ?,classificatorvalueid = ? WHERE pictureclassificatorvaluerelationid = ? ";

    }

    private function prepareInsertRelPattern()
    {
        return "INSERT INTO strunkovadb.tpictureclassificatorvaluerelations(pictureid,classificatorvalueid) VALUES (?,?)";
    }


    public function removePicture(Picture $picture)
    {
        global $db;
        $pattern = $this->prepareRemovePattern();
        $data = $this->prepareRemoveQueryData($picture);
        try {
            if ($pictures = $db->query($pattern, $data)) {
                unlink($picture->getPicPath());
                unlink($picture->getSketchPath());
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function removeRelation(PicClRel $pic_rel)
    {
        global $db;
        $pattern = $this->prepareRemovePattern();
        $data = $this->prepareRemoveQueryData($pic_rel);
        try {
            if ($db->query($pattern, $data)) {
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function prepareRemoveQueryData(PicClRel $pic_rel)
    {
        return array($pic_rel->getID());
    }

    private function prepareRemovePattern()
    {
        return "DELETE FROM strunkovadb.tpictureclassificatorvaluerelations WHERE tpictureclassificatorvaluerelations.pictureclassificatorvaluerelationid = ?";

    }

}
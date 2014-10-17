<?php
require_once 'phplibs/ResourceService.php';


class ClassificatorManager
{

    private static $db;

    public function __construct()
    {
        global $db;
        $resourceService = new ResourceService();
        $db = $resourceService->getDBConnection();
    }


    private function prepareSelectAllClassPattern()
    {
        return "SELECT * FROM strunkovadb.tclassificators ORDER BY engname";

    }

    private function prepareSelectAllValuesPattern()
    {
        return "SELECT * FROM strunkovadb.tclassificatorvalues ORDER BY path";

    }

    public function selectAllClassificators()
    {
        global $db;
        $class_pattern = $this->prepareSelectAllClassPattern();
        $values_pattern = $this->prepareSelectAllValuesPattern();
        try {
            if ($class = $db->query($class_pattern, NULL, 'assoc')  and $values = $db->query($values_pattern, NULL, 'assoc')) {
                $classObjs = $this->toClassObjects($class);
                $valueObjs = $this->toFirstLevelValueObjects($values);
                //$this->showTree($this->merge($classObjs, $valueObjs)); //den_debug
                return $this->merge($classObjs, $valueObjs);
            } else {
                return array();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function showTree(array $cls)
    {
        foreach ($cls as $cl) {
            $cl->echoValues();

        }
    }


    private function toClassObjects(array $class_array)
    {
        $objectArray = array();
        foreach ($class_array as $class) {
            $objectArray[] = $this->toClassObject($class);
        }
        return $objectArray;
    }

    private function toClassObject($c)
    {
        $id = $c['classificatorid'];

        $rusname = $c['rusname'];
        $engname = $c['engname'];

        return new Classificator($rusname, $engname, $id);
    }

    private function toFirstLevelValueObjects(array $values)
    {
        $firstLevelArray = array();
        $level_roots = array();
        foreach ($values as $value) {
            $valObj = $this->toValueObject($value);
            $level = $valObj->getLevel();
            $level_roots[$level] = $valObj;
            if ($level > 1) {
                $current_root = $level_roots[$level - 1];
                $current_root->addValue($valObj);
            } else {
                $firstLevelArray[] = $valObj;
            }
            $objectArray[] = $valObj;
        }
        //      var_dump($objectArray);
        return $objectArray;

    }

    private function toValueObject($value)
    {

        $id = $value['classificatorvalueid'];
        $classificatorid = $value['classificatorid'];
        $parent_id = $value['parentclassificatorvalueid'];

        $rusname = $value['rusvalue'];
        $engname = $value['engvalue'];
        $level = $value['level'];
        $path = $value['path'];
        // echo  $path.'<br>';

        return new ClassificatorValue($rusname, $engname, $id, $parent_id, $classificatorid, $level, $path);
    }

    private function merge(array $class_array, array $values_array)
    {
        $i = 0;
        foreach ($class_array as $class) {
            $class_id = $class->getID();
            //     echo  'class id'.$class_id.'<br>';      //den_debug

            //    $cid =  $values_array[$i] -> getClassificatorid();      //den_debug
            //      echo 'value_class '.$cid.'<br>';            //den_debug
            while ($i < sizeof($values_array) && $class_id == $values_array[$i]->getClassificatorid()) {
                //          echo 'while '.$cid.'<br>';         //den_debug
                $class->addValue($values_array[$i]);
                $i++;
            }
        }

        //   var_dump($class_array);
        return $class_array;
    }

    public function selectPicByID($pictureID)
    {
        global $db;
        $pattern = $this->prepareSelectPattern();
        try {
            if ($pictures = $db->query($pattern, array($pictureID), 'assoc')) {
                $res = $this->toPicObjects($pictures);
                return $res[0];
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }


    public function updatePicture(Picture $picture)
    {
        global $db;
        $pattern = $this->prepareUpdatePattern();
        $data = $this->prepareUpdateQueryData($picture);
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

    private function preparePattern()
    {
        return "INSERT INTO strunkovadb.tpictures (file_name,rate,rusdesc,engdesc,pic_path,sketch_path,position) VALUES (?,?,?,?,?,?,?)";

    }

    private function prepareUpdatePattern()
    {
        return "UPDATE strunkovadb.tpictures SET file_name = ?,rate = ?,rusdesc = ?,engdesc = ?,pic_path = ?,sketch_path = ?,position = ? WHERE pictureid = ? ";

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

    private function prepareRemoveQueryData(Picture $picture)
    {
        return array($picture->getFileName());
    }

    private function prepareRemovePattern()
    {
        return "DELETE FROM strunkovadb.tpictures WHERE file_name = ?";

    }

}
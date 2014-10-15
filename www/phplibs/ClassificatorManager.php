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
        return "SELECT * FROM strunkovadb.tclassificators";

    }

    private function prepareSelectAllValuesPattern()
    {
        return "SELECT * FROM strunkovadb.tclassificatorvalues";

    }

    public function selectAllClassificators()
    {
        global $db;
        $class_pattern = $this->prepareSelectAllClassPattern();
        $values_pattern = $this->prepareSelectAllValuesPattern();
        try {
            if ($class = $db->query($class_pattern, NULL, 'assoc')  and $values = $db->query($values_pattern, NULL, 'assoc')) {
                $classObjs = $this->toClassObjects($class);
                $valueObjs = $this->toValueObjects($values);
                return $this->merge($classObjs, $valueObjs);
            } else {
                return array();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
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

    private function toValueObjects(array $values)
    {
        $objectArray = array();
        foreach ($values as $value) {
            $objectArray[] = $this->toValueObject($value);
        }
        return $objectArray;

    }

    private function toValueObject($value)
    {

        $id = $value['classificatorvalueid'];
        $parent_id = $value['parentclassificatorvalueid'];

        $rusname = $value['rusvalue'];
        $engname = $value['engvalue'];
        $level = $value['level'];
        $path = $value['path'];

        return new ClassificatorValue($rusname, $engname, $id, $parent_id, $level, $path);
    }

    private function merge(array $class_array, array $values_array)
    {
        foreach ($class_array as $class) {
            echo $class->print_view();
        }
        foreach ($values_array as $value) {
            echo $value->print_view();
        }
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
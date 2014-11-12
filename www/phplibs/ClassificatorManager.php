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
        return "SELECT *,cast(classificatorid AS CHAR(10)) AS ord FROM strunkovadb.tclassificators ORDER BY ord ASC";

    }

    private function prepareSelectAllValuesPattern()
    {
        return "SELECT * FROM strunkovadb.tclassificatorvalues ORDER BY path_ids ASC ";

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
            // $objectArray[] = $valObj;
        }
        return $firstLevelArray;

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

    public function selectClByID($ID)
    {
        global $db;
        $pattern = $this->prepareSelectOnePattern();
        try {
            if ($cls = $db->query($pattern, array($ID), 'assoc')) {
                $res = $this->toClassObject($cls[0]);
                return $res;
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function selectVlByID($ID)
    {
        global $db;
        $pattern = $this->prepareSelectOneVlPattern();
        try {
            if ($cls = $db->query($pattern, array($ID), 'assoc')) {
                $res = $this->toValueObject($cls[0]);
                return $res;
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }


    private function prepareSelectOnePattern()
    {
        return "SELECT * FROM strunkovadb.tclassificators WHERE classificatorid = ?"; //den_debug remove sketch_path <> ''

    }

    private function prepareSelectOneVlPattern()
    {
        return "SELECT * FROM strunkovadb.tclassificatorvalues WHERE classificatorvalueid = ?"; //den_debug remove sketch_path <> ''

    }

    public function updateCl(Classificator $cl)
    {
        $old_cl_id = $cl->getID();
        $old_cl = $this->selectClByID($old_cl_id);
        $old_path = $old_cl->getEngName();
        global $db;
        $pattern = $this->prepareUpdateClPattern();
        $data = $this->prepareUpdateClQueryData($cl);

        $children_pattern = $this->prepareUpdateClChildrenPattern();

        try {
            if ($db->query($pattern, $data) and $db->query($children_pattern, array($old_path . '%'))) {
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }


    public function insertCl(Classificator $cl)
    {
        global $db;
        $pattern = $this->prepareInsertClPattern();
        $data = $this->prepareInsertClQueryData($cl);
        try {
            if ($db->query($pattern, $data)) {
                $last_id = $this->getLastID();
                return $last_id;
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }


    public function getLastID()
    {
        global $db;
        $pattern = $this->prepareGetLastIDPattern();
        try {
            if ($res = $db->query($pattern, NULL, 'assoc')) {
                $first_row = $res[0];
                return $first_row['id'];
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }


    private function prepareInsertClQueryData(Classificator $cl)
    {
        return array($cl->getRusName(), $cl->getEngName());
    }

    private function prepareUpdateClQueryData(Classificator $cl)
    {
        return array($cl->getRusName(), $cl->getEngName(), $cl->getID());
    }

    private function prepareInsertClPattern()
    {
        return "INSERT INTO strunkovadb.tclassificators (rusname,engname) VALUES (?,?);";
    }

    private function prepareGetLastIDPattern()
    {
        return "SELECT LAST_INSERT_ID() as id;";
    }

    private function prepareUpdateClPattern()
    {
        return "UPDATE strunkovadb.tclassificators SET rusname = ?,engname= ? WHERE classificatorid = ? ";

    }


    private function prepareUpdateClChildrenPattern()
    {
        $res = 'UPDATE strunkovadb.tclassificatorvalues SET path =path WHERE path LIKE ? ORDER BY path_ids ASC';
        return $res;
    }


    public function updateVl(ClassificatorValue $clv)
    {
        $old_vl_id = $clv->getID();
        $old_vl = $this->selectVlByID($old_vl_id);
        $old_path = $old_vl->getPath();
        global $db;
        $pattern = $this->prepareUpdateVlPattern();
        $data = $this->prepareUpdateVLQueryData($clv);

        $children_pattern = $this->prepareUpdateClChildrenPattern();
        try {
            if ($db->query($pattern, $data) and $db->query($children_pattern, array($old_path . '%'))) {
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }


    public function InsertVl(ClassificatorValue $clv)
    {
        global $db;
        $pattern = $this->prepareInsertVlPattern();
        $data = $this->prepareInsertVlQueryData($clv);
        $res = array();
        try {

            if ($db->query($pattern, $data)) {

                $last_id = $this->getLastID();
                $res['return_code'] = 0;
                $res['res'] = $last_id;

            } else {
                $res['return_code'] = -1;
                $res['error_message'] = 'error was occurred';
            }
            return $res;
        } catch (Exception $e) {
            $mes = $e->getMessage();
            $res['return_code'] = -1;
            $res['error_message'] = $mes;
            return $res;
        }
    }


    private function prepareUpdateVlQueryData(ClassificatorValue $clv)
    {
        return array($clv->getRusValue(), $clv->getEngValue(), $clv->getID());
    }

    private function prepareInsertVlQueryData(ClassificatorValue $clv)
    {
        return array($clv->getRusValue(), $clv->getEngValue(), $clv->getParentID(), $clv->getClassificatorid());
    }

    private function prepareInsertVlPattern()
    {
        return "INSERT INTO strunkovadb.tclassificatorvalues (rusvalue,engvalue,parentclassificatorvalueid,classificatorid) VALUES (?,?,?INT-NULL,?)";

    }

    private function prepareUpdateVlPattern()
    {
        return "UPDATE strunkovadb.tclassificatorvalues SET rusvalue = ?,engvalue= ? WHERE classificatorvalueid = ? ";

    }


    public function removeClByID($cl_id)
    {
        global $db;
        $pattern = $this->prepareRemoveClPattern();
        $data = $this->prepareRemoveClQueryData($cl_id);
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

    public function removeCl(Classificator $cl)
    {
        removeClByID($cl->getID());
    }

    private function prepareRemoveClQueryData($cl_id)
    {
        return array($cl_id);
    }

    private function prepareRemoveClPattern()
    {
        return "DELETE FROM strunkovadb.tclassificators WHERE classificatorid = ?";
    }

    public function removeVl(ClassificatorValue $vl)
    {
        removeClByID($vl->getID());
    }

    public function removeVlByID($vl_id)
    {
        global $db;
        $pattern = $this->prepareVlRemovePattern();
        try {
            if ($db->query($pattern, array($vl_id))) {
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function prepareVlRemovePattern()
    {
        return "DELETE FROM strunkovadb.tclassificatorvalues WHERE classificatorvalueid = ?";

    }

}
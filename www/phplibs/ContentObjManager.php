<?php
require_once 'phplibs/ResourceService.php';


class ContentObjManager
{

    private static $db;

    public function __construct()
    {
        global $db;
        $resourceService = new ResourceService();
        $db = $resourceService->getDBConnection();
    }

    private function prepareSelectPattern()
    {
        return "SELECT * FROM strunkovadb.tcontent WHERE  id = ?";

    }

    private function toContentObjects(array $objs)
    {
        $objectArray = array();
        foreach ($objs as $obj) {
            $id = $obj['id'];
            $value = $obj['value'];
            $contentObj = new ContentObj($id,$value);


            $objectArray[] = $contentObj;
        }
        return $objectArray;
    }

    public function selectByID($id)
    {
        global $db;
        $pattern = $this->prepareSelectPattern();

        try {
            if ($objs = $db->query($pattern, array($id), 'assoc') ) {

                $res = $this->toContentObjects($objs);
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



    public function update(ContentObj $obj)
    {
        global $db;
        $pattern = $this->prepareUpdatePattern();
        $data = $this->prepareUpdateQueryData($obj);
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




    public function save(ContentObj $obj)
    {
        global $db;
        $pattern = $this->prepareSavePattern();
        $data = $this->prepareSaveQueryData($obj);
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

    private function prepareGetLastIDPattern()
    {
        return "SELECT LAST_INSERT_ID() as id;";
    }


    private function prepareSaveQueryData(ContentObj $obj)
    {
        return array($obj->getValue());
    }

    private function prepareUpdateQueryData(ContentObj $obj)
    {
        return array($obj->getValue(), $obj->getID() );
    }


    private function prepareSavePattern()
    {
        return "INSERT INTO strunkovadb.tcontent (value) VALUES (?)";

    }

    private function prepareUpdatePattern()
    {
        return "UPDATE strunkovadb.tcontent SET value = ? WHERE id = ? ";

    }


    public function remove(ContentObj $obj)
    {
        global $db;
        $pattern = $this->prepareRemovePattern();
        $data = $this->prepareRemoveQueryData($obj);
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

    private function prepareRemoveQueryData(ContentObj $obj)
    {
        return array($obj->getID());
    }

    private function prepareRemovePattern()
    {
        return "DELETE FROM strunkovadb.tcontent WHERE id = ?";

    }
}
<?php
require_once 'phplibs/ResourceService.php';


class ExpositionManager
{

    private static $db;

    public function __construct()
    {
        global $db;
        $resourceService = new ResourceService();
        $db = $resourceService->getDBConnection();
    }



    private function toExpoObjects(array $db_objs)
    {
        $objArray = array();
        foreach ($db_objs as $db_obj) {
            $id = (int)$db_obj['expoid'];
            $pictureID = (int)$db_obj['pictureid'];
            $songID = (int)$db_obj['songid'];


            $left = $db_obj['left'];
            $width = $db_obj['width'];
            $ratio = $db_obj['ratio'];
            $top = $db_obj['top'];

            $obj = new Exposition($id,$pictureID,$songID,$left, $width,$top, $ratio);
            $objArray[] = $obj;
        }
        return $objArray;
    }

    public function selectExpositionByID($expositionID)
    {
        global $db;
        $sel_pattern = $this->prepareExpoSelectPattern();

        try {
            if ($objs = $db->query($sel_pattern, array($expositionID), 'assoc') ) {
                $res = $this->toExpoObjects($objs);
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

    public function selectExpositionByPicID($picID)
    {
        global $db;

        try {
            if ($objs = $db->query("SELECT expoid, pictureid,songid,`left`,width,ratio,top FROM strunkovadb.texpo where pictureid = ?", array($picID), 'assoc') ) {
                $res = $this->toExpoObjects($objs);
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

    public function selectExpositionBySongID($songID)
    {
        global $db;

        try {
            if ($objs = $db->query("SELECT expoid, pictureid,songid,`left`,width,ratio,top FROM strunkovadb.texpo where songid = ?", array($songID), 'assoc') ) {
                $res = $this->toExpoObjects($objs);
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



    public function updateObject(Exposition $obj)
    {
        global $db;
        $pattern = $this->prepareUpdatePattern();
        $data = $this->prepareUpdateQueryData($obj);
        try {
            if ($objs = $db->query($pattern, $data)) {
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function save(Exposition $obj)
    {
        global $db;
        $pattern = $this->preparePattern();
        $data = $this->prepareQueryData($obj);
        try {
            if ($objs = $db->query($pattern, $data)) {
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
        try {
            if ($res = $db->query("SELECT LAST_INSERT_ID() as id;", NULL, 'assoc')) {
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

    private function prepareQueryData(Exposition $obj)
    {
        return array($obj-> getPicID(),$obj-> getSongID(),$obj ->getLeft(),$obj ->getWidth(),$obj ->getRatio(),$obj ->getTop() );
    }

    private function prepareUpdateQueryData(Exposition $obj)
    {
        return array($obj-> getPicID(),$obj-> getSongID(),$obj ->getLeft(),$obj ->getWidth(),$obj ->getRatio(),$obj ->getTop(), $obj->getId() );
    }

    private function preparePattern()
    {
        return "INSERT INTO strunkovadb.texpo (pictureid,songid,`left`,width,ratio,top) VALUES (?INT-NULL,?INT-NULL,?,?,?,?)";

    }

    private function prepareExpoSelectPattern()
    {
        return "SELECT pictureid,songid,`left`,width,ratio,top FROM strunkovadb.texpo where expoid = ?";

    }

    private function prepareUpdatePattern()
    {
        return "UPDATE strunkovadb.texpo SET pictureid = ?INT-NULL,songid = ?INT-NULL,`left` = ?,width = ?,ratio = ?,top = ? WHERE expoid = ? ";

    }

    public function remove(Exposition $obj)
    {
        global $db;
        $pattern = $this->prepareRemovePattern();
        $data = $this->prepareRemoveQueryData($obj);
        try {
            if ($objs = $db->query($pattern, $data)) {
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function prepareRemoveQueryData(Exposition $obj)
    {
        return array($obj->getId());
    }

    private function prepareRemovePattern()
    {
        return "DELETE FROM strunkovadb.texpo WHERE expoid = ?";

    }


}
<?php
    require_once 'phplibs/ResourceService.php';


class PictureObjManager {

    private static $db;

    public  function __construct() {
        global $db;
        $resourceService = new ResourceService();
        $db              = $resourceService->getDBConnection();
    }

    public function savePicture($picture){
        global $db;
        $pattern =  $this -> preparePattern();
        $data = $this -> prepareQueryData($picture);
        try {
            if ($pictures = $db->query($pattern,$data)) {
                return 'ok';
            } else {
                return null;
            }
        }
        catch(Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    private function prepareQueryData($picture) {
        $descriptions = $picture -> getMultilangDescription();
        return array($picture -> getFileName(),$picture->getRate(),$descriptions['rus'],$descriptions['eng'],$picture->getPicPath(),$picture->getSketchPath(),$picture->getPosition());
    }

    private function preparePattern() {
        return "INSERT INTO strunkovadb.tpictures (file_name,rate,rusdesc,engdesc,pic_path,sketch_path,position) VALUES (?,?,?,?,?,?,?)";

    }


    public function removePicture($picture){
        global $db;
        $pattern =  $this -> prepareRemovePattern();
        $data = $this -> prepareRemoveQueryData($picture);
        try {
            if ($pictures = $db->query($pattern,$data)) {
                unlink($picture->getPicPath());
                unlink($picture->getSketchPath());
                return 'ok';
            } else {
                return null;
            }
        }
        catch(Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }
    private function prepareRemoveQueryData($picture) {
        return array($picture -> getFileName());
    }

    private function prepareRemovePattern() {
        return "DELETE FROM strunkovadb.tpictures WHERE file_name = ?";

    }

}
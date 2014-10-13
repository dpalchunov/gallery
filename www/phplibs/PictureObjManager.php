
<?php
    require_once 'phplibs/ResourceService.php';


class PictureObjManager {

    private static $db;

    public  function __construct() {
        global $db;
        $resourceService = new ResourceService();
        $db              = $resourceService->getDBConnection();
    }

    private function prepareSelectPattern() {
        return "select * from strunkovadb.tpictures where sketch_path <> '' and  pictureid = ?";  //den_debug remove sketch_path <> ''

    }
    private function prepareSelectAllPattern() {
        return "select * from strunkovadb.tpictures where sketch_path <> ''"; //den_debug remove sketch_path <> ''

    }

    public function selectAllPics(){
        global $db;
        $pattern =  $this -> prepareSelectAllPattern();
        try {
            if ($pictures = $db->query($pattern,NULL,'assoc')) {
                return $this -> toPicObjects($pictures);
            } else {
                return array();
            }
        }
        catch(Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function toPicObjects($pictures) {
        $pictureObjectArray = array();
        foreach ($pictures as $picture) {
            $pictureID = $picture['pictureid'];

            $rusDesc = $picture['rusdesc'];
            $engDesc = $picture['engdesc'];

            $fileName = $picture['file_name'];
            $position = $picture['position'];
            $rate = $picture['rate'];
            $multilangDesc = array (
                'rus' => $rusDesc,
                'eng' => $engDesc
            );
            $picPath = $picture['pic_path'];
            $sketchPath = $picture['sketch_path'];

            $pictureObject = new Picture($fileName, $position, $rate, $multilangDesc, $picPath, $sketchPath,$pictureID);
            $pictureObjectArray[] = $pictureObject;
        }
        return  $pictureObjectArray;
    }

    public function selectPicByID($pictureID){
        global $db;
        $pattern =  $this -> prepareSelectPattern();
        try {
            if ($pictures = $db->query($pattern,array($pictureID),'assoc')) {
                $this -> toPicObjects($pictures);
            } else {
                return null;
            }
        }
        catch(Exception $e) {
            echo $e->getMessage();
            return null;
        }
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
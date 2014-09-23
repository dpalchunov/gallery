<?php
/**
 * Created by IntelliJ IDEA.
 * User: dpalchunov
 * Date: 23/09/14
 * Time: 10:28
 * To change this template use File | Settings | File Templates.
 */

class PictureSaver {

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
        $descriptions = $picture -> getDescription;
        return array($picture -> getFileName(),$picture->getRate,$descriptions('rus'),$descriptions('eng'));
    }

    private function preparePattern() {
        return "INSERT INTO \'strunkovadb.tpictures\' (\'file_name\',\'rate\',\'rusdesc\',\'engdesc\') VALUES (?,?,?,?)";

    }
}
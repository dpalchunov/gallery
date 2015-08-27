<?php
require_once 'phplibs/ResourceService.php';


class VideoObjManager
{

    private static $db;

    public function __construct()
    {
        global $db;
        $resourceService = new ResourceService();
        $db = $resourceService->getDBConnection();
    }

    private function prepareVidSelectPattern()
    {
        return "SELECT * FROM strunkovadb.tvideos WHERE  videoid = ?";

    }

    private function prepareSelectAllPattern()
    {
        return "SELECT * FROM strunkovadb.tvideos ORDER BY position";
    }

    private function prepareSelectFirstPattern()
    {
        return "SELECT * FROM strunkovadb.tvideos LIMIT 1 ORDER BY position";
    }

    private function prepareSelectPagePattern($active_page)
    {
        $vid_per_page = 5;
        $from = ($active_page - 1) * $vid_per_page;
        $sql = "SELECT * FROM strunkovadb.tvideos order by position LIMIT " . "{$from}" . "," . "{$vid_per_page}";
        return $sql;
    }

    public function selectAllVideos()
    {
        global $db;
        $pattern = $this->prepareSelectAllPattern();
        try {
            if ($videos = $db->query($pattern, NULL, 'assoc') ) {
                return $this->toVidObjects($videos);
            } else {
                return array();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function selectFirstVideo()
    {
        global $db;
        $pattern = $this->prepareSelectFirstPattern();
        try {
            if ($videos = $db->query($pattern, NULL, 'assoc') ) {
                return $this->toVidObjects($videos);
            } else {
                return array();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function selectPage($page)
    {
        global $db;
        $pattern = $this->prepareSelectPagePattern($page);
        try {
            if ($videos = $db->query($pattern, NULL, 'assoc') ) {
                return $this->toVidObjects($videos);
            } else {
                return array();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function toVidObjects(array $videos)
    {
        $objectArray = array();
        foreach ($videos as $video) {
            $videoID = (int)$video['videoid'];

            $rusDesc = $video['rusdesc'];
            $engDesc = $video['engdesc'];

            $fileName = $video['file_name'];
            $position = $video['position'];
            $multilangDesc = array(
                'rus' => $rusDesc,
                'eng' => $engDesc
            );
            $thumbnail = $video['thumbnail'];
            $path = $video['path'];

            $object = new Video($fileName, $position, $multilangDesc, $path, $thumbnail, $videoID);

            $objectArray[] = $object;
        }
        return $objectArray;
    }

    public function selectVidByID($videoID)
    {
        global $db;
        $vid_pattern = $this->prepareVidSelectPattern();

        try {
            if ($videos = $db->query($vid_pattern, array($videoID), 'assoc')) {
                $res = $this->toVidObjects($videos);
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

    public function updateVideo(Video $video)
    {
        global $db;
        $pattern = $this->prepareUpdatePattern();
        $data = $this->prepareUpdateQueryData($video);
        try {
            if ($videos = $db->query($pattern, $data)) {
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function saveVideo(Video $video)
    {
        global $db;
        $pattern = $this->preparePattern();
        $data = $this->prepareQueryData($video);
        try {
            if ($videos = $db->query($pattern, $data)) {
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

    private function prepareQueryData(Video $video)
    {
        $descriptions = $video->getMultilangDescription();
        return array($video->getFileName(), $descriptions['rus'], $descriptions['eng'], $video->getPath(), $video->getThumbnail(), $video->getPosition());
    }

    private function prepareUpdateQueryData(Video $video)
    {
        $descriptions = $video->getMultilangDescription();
        return array($video->getFileName(), $descriptions['rus'], $descriptions['eng'], $video->getPath(), $video->getThumbnail(), $video->getPosition(), $video->getID());
    }

    private function preparePattern()
    {
        return "INSERT INTO strunkovadb.tvideos (file_name,rusdesc,engdesc,path,thumbnail,position) VALUES (?,?,?,?,?,?)";

    }

    private function prepareUpdatePattern()
    {
        return "UPDATE strunkovadb.tvideos SET file_name = ?,rusdesc = ?,engdesc = ?,path = ?,thumbnail =?, position = ? WHERE videoid = ? ";

    }

    public function removeVideo(Video $video)
    {
        global $db;
        $pattern = $this->prepareRemovePattern();
        $data = $this->prepareRemoveQueryData($video);
        try {
            if ($videos = $db->query($pattern, $data)) {
                if (file_exists($video->getPath())) {
                    unlink($video->getPath());
                };
                if (file_exists($video->getThumbnail())) {
                    unlink($video->getThumbnail());
                };
                if (file_exists($video->getThumbnail())) {
                    unlink($video->getThumbnail());
                };
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    private function prepareRemoveQueryData(Video $video)
    {
        return array($video->getFileName());
    }

    private function prepareRemovePattern()
    {
        return "DELETE FROM strunkovadb.tvideos WHERE file_name = ?";

    }

    public function getCount()
    {
        global $db;
        $pattern = 'SELECT count(*) AS cnt FROM tvideos';
        try {
            if ($r_tmp = $db->query($pattern, NULL, 'assoc')) {
                $res = $r_tmp[0];
                return $res['cnt'];
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

}
<?php
require_once 'phplibs/ResourceService.php';


class SongsObjManager
{

    private static $db;

    public function __construct()
    {
        global $db;
        $resourceService = new ResourceService();
        $db = $resourceService->getDBConnection();
    }

    private function prepareSongSelectPattern()
    {
        return "SELECT * FROM strunkovadb.tsongs WHERE  songid = ?";

    }


    private function prepareSelectAllPattern()
    {
        return "SELECT * FROM strunkovadb.tsongs";
    }

    private function prepareSelectPagePattern($active_page)
    {
        $song_per_page = 5;
        $from = ($active_page - 1) * $song_per_page;
        if ($from < 0) {
            $from = 0;
        }
        $sql = "SELECT * FROM strunkovadb.tsongs LIMIT " . "{$from}" . "," . "{$song_per_page}";
        return $sql;
    }


    public function selectAllSongs()
    {
        global $db;
        $pattern = $this->prepareSelectAllPattern();
        try {
            if ($songs = $db->query($pattern, NULL, 'assoc') ) {
                return $this->toSongObjects($songs);
            } else {
                return array();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function selectSongsPage($page)
    {
        global $db;
        $pattern = $this->prepareSelectPagePattern($page);
        try {
            if ($songs = $db->query($pattern, NULL, 'assoc')) {
                return $this->toSongObjects($songs);
            } else {
                return array();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }


    private function toSongObjects(array $objs)
    {
        $songObjectArray = array();
        foreach ($objs as $obj) {
            $songid = (int)$obj['songid'];

            $rusName = $obj['rusname'];
            $engName = $obj['engname'];

            $fileName = $obj['filename'];
            $multilangDesc = array(
                'rus' => $rusName,
                'eng' => $engName
            );

            $songObject = new Song($fileName, $multilangDesc,$songid);
            $em =  new ExpositionManager();
            $expo = $em->selectExpositionBySongID($songid);
            $songObject ->setExpoPosition($expo);

            $songObjectArray[] = $songObject;
        }
        return $songObjectArray;
    }

    public function selectSongByID($songID)
    {
        global $db;
        $song_pattern = $this->prepareSongSelectPattern();

        try {
            if ($song = $db->query($song_pattern, array($songID), 'assoc'))  {
                $res = $this->toSongObjects($song);
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



    public function updateSong(Song $song)
    {
        global $db;
        $pattern = $this->prepareUpdatePattern();
        $data = $this->prepareUpdateQueryData($song);
        try {
            if ($songs = $db->query($pattern, $data)) {
                return 'ok';
            } else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return null;
        }
    }







    public function saveSong(Song $song)
    {
        global $db;
        $pattern = $this->preparePattern();
        $data = $this->prepareQueryData($song);
        try {
            if ($songs = $db->query($pattern, $data)) {
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


    private function prepareQueryData(Song $song)
    {
        $descriptions = $song->getMultilangDescription();
        return array($song->getFileName(), $descriptions['rus'], $descriptions['eng']);
    }

    private function prepareUpdateQueryData(Song $song)
    {
        $descriptions = $song->getMultilangDescription();
        return array($song->getFileName(),$descriptions['rus'], $descriptions['eng'], $song->getID());
    }


    private function preparePattern()
    {
        return "INSERT INTO strunkovadb.tsongs (filename,rusname,engname) VALUES (?,?,?)";

    }

    private function prepareUpdatePattern()
    {
        return "UPDATE strunkovadb.tsongs SET filename = ?,rusname = ?,engname = ?  WHERE songid = ? ";

    }

    public function removeSong(Song $song)
    {
        global $db;
        $pattern = $this->prepareRemovePattern();
        $data = $this->prepareRemoveQueryData($song);
        try {
            if ($songs = $db->query($pattern, $data)) {
                if (file_exists($song->getPath())) {
                    unlink($song->getPath());
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



    private function prepareRemoveQueryData(Song $song)
    {
        return array($song->getID());
    }

    private function prepareRemovePattern()
    {
        return "DELETE FROM strunkovadb.tsongs WHERE songid = ?";

    }

    public function getCount()
    {
        global $db;
        $pattern = 'SELECT count(*) AS cnt FROM tsongs';
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
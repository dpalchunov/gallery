<?php
    if (isset($_POST['avatar_src'])) {
        $type = exif_imagetype($_POST['avatar_src']);

        if ($type) {
            $extension = image_type_to_extension($type);
            $dir = 'images/slider/avas';
            if (!file_exists($dir)) {
                mkdir($dir, 0777);
            }
            $dst = $dir . '/' . date('YmdHis').getmicrotime(). $extension;
            $name = $_POST['avatar_src'];
            $res = rename($name,$dst);
            echo json_encode($res);
        }
    }

    function getmicrotime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
?>
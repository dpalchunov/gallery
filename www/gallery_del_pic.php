<?php
    $picPath = './images/gallary/' . $_POST['file_name'];
    $sketchPath = './images/gallary/sketches/' . $_POST['file_name'];
    $res =unlink($picPath);
    $res =unlink($sketchPath);
    echo json_encode($res);
?>
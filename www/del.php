<?php
    $res =unlink($_POST['src']);
    echo json_encode($res);
?>
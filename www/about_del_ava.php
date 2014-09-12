<?php
    $res =unlink($_POST['avatar_src']);
    echo json_encode($res);
?>
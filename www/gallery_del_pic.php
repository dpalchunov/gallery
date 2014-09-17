<?php
$res =unlink($_POST['pic_src']);
echo json_encode($res);
?>
<?php
require_once 'phplibs/ResourceService.php';

$crop = new IntroCropper($_POST['avatar_src'], $_POST['avatar_data']);
$response = array(
    'state' => 200,
    'message' => $crop->getMsg(),
    'result' => $crop->getResult()
);

echo json_encode($response);
?>
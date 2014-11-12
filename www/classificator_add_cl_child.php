<?php

require_once 'phplibs/ClassificatorManager.php';
$man = new ClassificatorManager();

$vl = new ClassificatorValue($_POST["rus_value"], $_POST["eng_value"], null, $_POST["classificator_id"]);

$res = $man->insertVl($vl);
echo json_encode($res);

?>
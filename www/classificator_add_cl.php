<?php

require_once 'phplibs/ClassificatorManager.php';
$man = new ClassificatorManager();
$cl = new Classificator($_POST["rus_name"], $_POST["eng_name"]);

$res = $man->insertCl($cl);
echo $res;

?>
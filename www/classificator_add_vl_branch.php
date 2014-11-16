<?php

require_once 'phplibs/ClassificatorManager.php';
$man = new ClassificatorManager();
$cl_id = $_POST['cl_id'];
$v_id = $_POST['v_id'];
$new_branch = $_POST['new_branch'];
$ret_code = 0;
$eng_values = explode('/', $new_branch);
$error = '';
$res;
foreach ($eng_values as $eng_value) {
    if ($ret_code == 0) {
        $vl = new ClassificatorValue($eng_value, $eng_value, $v_id, $cl_id);
        $res = $man->insertVl($vl);
        $v_id = $res['res'];
        $ret_code = $res['return_code'];
        $error = $res['error_message'];

    }
};
if ($ret_code == 0) {
    echo 'ok';
} else {
    echo $error;
}

?>
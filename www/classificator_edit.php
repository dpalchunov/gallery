<?php

require_once 'phplibs/ResourceService.php';
require_once './helpers.php';

$actions = array(
    "add_cl" => array ("type" => "super_role"),
    "add_cl_child" => array ("type" => "super_role"),
    "add_vl_branch" => array ("type" => "super_role"),
    "add_vl_child" => array ("type" => "super_role"),
    "del_cl" => array ("type" => "super_role"),
    "del_v" => array ("type" => "super_role"),
    "get_cl_html" => array ("type" => "super_role"),
    "get_html" => array ("type" => "super_role"),
    "get_vl_html" => array ("type" => "super_role"),
    "get_paths" => array ("type" => "everyone"),
    "update" => array ("type" => "super_role"),
    "value_update" => array ("type" => "super_role")
);

function common_action_handler() {
    $galleryEditor = new ClassificatorEditor();
    $galleryEditor-> editClassificator();
}

function add_cl_handler() {
    $man = new ClassificatorManager();
    $cl = new Classificator($_POST["rus_name"], $_POST["eng_name"]);

    $res = $man->insertCl($cl);
    echo $res;
}
function add_cl_child_handler() {
    $man = new ClassificatorManager();

    $vl = new ClassificatorValue($_POST["rus_value"], $_POST["eng_value"], null, $_POST["classificator_id"]);

    $res = $man->insertVl($vl);
    echo json_encode($res);
}
function add_vl_branch_handler() {
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

    echo json_encode($res);
}
function add_vl_child_handler() {
    $man = new ClassificatorManager();
    $vl = new ClassificatorValue($_POST["rus_value"], $_POST["eng_value"], $_POST["parent_id"], $_POST["classificator_id"]);
    $res = $man->insertVl($vl);
    echo json_encode($res);
}
function del_cl_handler() {
    $man = new ClassificatorManager();

    $res = $man->removeClByID($_POST["id"]);
    echo $res;
}
function del_v_handler() {
    $man = new ClassificatorManager();

    $res = $man->removeVlByID($_POST["id"]);
    echo $res;
}
function get_cl_html_handler() {
    $getter = new ClassificatorEditHtmlGetter();
    $m = new ClassificatorManager();
    $cl = $m->selectClByID($_POST['id']);
    $html_code = $getter->getClHtmlCode($cl);
    echo $html_code;
}

function get_html_handler() {
    $getter = new ClassificatorEditHtmlGetter();
    $html_code = $getter->getHTMLCode();
    echo $html_code;
}
function get_vl_html_handler() {
    $getter = new ClassificatorEditHtmlGetter();
    $m = new ClassificatorManager();
    $vl = $m->selectVlByID($_POST['id']);
    $html_code = $getter->getVlHtmlCode($vl);
    echo $html_code;
}
function get_paths_handler() {
    require_once 'phplibs/ClassificatorManager.php';
    $man = new ClassificatorManager();
    $res = $man->getValuesPaths();
    echo json_encode($res);
}
function update_handler() {
    $man = new ClassificatorManager();

    $cl = $man->selectClByID($_POST["id"]);
    if ($cl != null) {
        $cl->setRusName($_POST["rus_name"]);
        $cl->setEngName($_POST["eng_name"]);

        $res = $man->updateCl($cl);
    } else {
        $res = 'No cl with submitted id';
    }
    echo $res;
}
function value_update_handler() {
    $man = new ClassificatorManager();

    $vl = $man->selectVlByID($_POST["id"]);
    if ($vl != null) {
        $vl->setRusName($_POST["rus_value"]);
        $vl->setEngName($_POST["eng_value"]);


        $res = $man->updateVl($vl);
    } else {
        $res = 'No classifier value with submitted id';
    }
    echo $res;
}


require_once './router.php';
?>

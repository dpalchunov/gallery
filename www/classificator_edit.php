<?php

require_once 'phplibs/ResourceService.php';

session_start();
if ( isset($_SESSION['state'])) {
    if ( isset($_POST['action'])) {
        $action = $_POST['action'];
        if ($action == 'add_cl') {
            $man = new ClassificatorManager();
            $cl = new Classificator($_POST["rus_name"], $_POST["eng_name"]);

            $res = $man->insertCl($cl);
            echo $res;
        }   else if ($action == 'add_cl_child') {
            $man = new ClassificatorManager();

            $vl = new ClassificatorValue($_POST["rus_value"], $_POST["eng_value"], null, $_POST["classificator_id"]);

            $res = $man->insertVl($vl);
            echo json_encode($res);


        }   else if ($action == 'add_vl_branch') {
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
           else if ($action == 'add_vl_child') {
               $man = new ClassificatorManager();
               $vl = new ClassificatorValue($_POST["rus_value"], $_POST["eng_value"], $_POST["parent_id"], $_POST["classificator_id"]);
               $res = $man->insertVl($vl);
               echo json_encode($res);
        }   else if ($action == 'del_cl') {
               require_once 'phplibs/ClassificatorManager.php';
               $man = new ClassificatorManager();

               $res = $man->removeClByID($_POST["id"]);
               echo $res;
        }   else if ($action == 'get_cl_html') {
               $getter = new ClassificatorEditHtmlGetter();
               $m = new ClassificatorManager();
               $cl = $m->selectClByID($_POST['id']);
               $html_code = $getter->getClHtmlCode($cl);
               echo $html_code;
        }   else if ($action == 'get_html') {
               $getter = new ClassificatorEditHtmlGetter();
               $html_code = $getter->getHTMLCode();
               echo $html_code;
        }   else if ($action == 'get_vl_html') {
               $getter = new ClassificatorEditHtmlGetter();
               $m = new ClassificatorManager();
               $vl = $m->selectVlByID($_POST['id']);
               $html_code = $getter->getVlHtmlCode($vl);
               echo $html_code;
        }   else if ($action == 'get_paths') {
               require_once 'phplibs/ClassificatorManager.php';
               $man = new ClassificatorManager();
               $res = $man->getValuesPaths();
               echo json_encode($res);

        }   else if ($action == 'update') {
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
        }   else if ($action == 'value_update') {
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
    } else {
        $galleryEditor = new ClassificatorEditor();
        $galleryEditor-> editClassificator();
    }
}
else {
    echo 'page not found';
}

?>
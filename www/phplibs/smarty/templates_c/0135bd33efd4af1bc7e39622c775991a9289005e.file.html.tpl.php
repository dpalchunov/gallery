<?php /* Smarty version Smarty-3.1.11, created on 2012-08-22 01:00:02
         compiled from "phplibs\smarty\templates\html.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1188503031db94c686-19033534%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0135bd33efd4af1bc7e39622c775991a9289005e' => 
    array (
      0 => 'phplibs\\smarty\\templates\\html.tpl',
      1 => 1345582800,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1188503031db94c686-19033534',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_503031db9587a2_24573303',
  'variables' => 
  array (
    'html_body' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_503031db9587a2_24573303')) {function content_503031db9587a2_24573303($_smarty_tpl) {?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN
<html lang="ru-RU">
  <head>
    <title>Filter</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="js/jquery.js"></script>

    <!--Скрипт для выезжающей панели-->	
    <script type="text/javascript">
    $(function(){
      $("input:checkbox").live("change", checkboxClickHandler);      
    });
    
    function checkboxClickHandler(mes) {        
        setChildrensState(this.getAttribute("name"));
        if (this.getAttribute("parent") != "") {
          setParentState(this.getAttribute("parent"));
        }
        refreshPictures();
    }
    
    function refreshPictures() {
      make  
    }
    
    //sets checkbox state in relation of childrens
    function setParentState(parentName) {
      $('input[name="' + parentName + '"]').unbind("change");
      allChildrenIsChecked = true;
      allChildrenIsUnchecked = true;
      $('input[parent="' + parentName + '"]').each(function(index, element){
        if (element.checked) {
          allChildrenIsUnchecked = false;  
        } else {
          allChildrenIsChecked = false;
        }
      });
      if (allChildrenIsChecked) {
        $('input[name="' + parentName + '"]').attr("checked","checked");  
      } else if (allChildrenIsUnchecked) {
                $('input[name="' + parentName + '"]').attr("checked",false);             
             } else {
                $('input[name="' + parentName + '"]').attr("checked",true);
                //а здесь надо картинку его менять
             }
      //alert($('input[name="' + parentName + '"]').attr("parent"));
      if (($('input[name="' + parentName + '"]').attr("parentName") != '') & (typeof $('input[name="' + parentName + '"]').attr("parentName") != "undefined")) {
        setParentState($('input[name="' + parentName + '"]').attr("parent")); 
      } 
      $('input[name="' + parentName + '"]').bind("change", checkboxClickHandler);
    }
    
    //sets childrens checkboxes states in relation of parent 
    function setChildrensState(parentName) {
      $('input[name="' + parentName + '"]').unbind("change");
      $('input[parent="' + parentName + '"]').each(function(index, element){
        element.checked = $('input[name="' + parentName + '"]').attr("checked");
        setChildrensState(element.name);
      });
      $('input[name="' + parentName + '"]').bind("change", checkboxClickHandler);
    }    
    </script>    
  </head>
  <body>
    <form enctype="multipart/form-data" action="process_form.php" method="post"> 
      <?php echo $_smarty_tpl->tpl_vars['html_body']->value;?>

      <input type="submit" value="Отправить"> 
    </form>
  </body>
</html><?php }} ?>
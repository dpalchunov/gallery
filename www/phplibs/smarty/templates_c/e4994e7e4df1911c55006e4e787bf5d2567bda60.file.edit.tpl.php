<?php /* Smarty version Smarty-3.1.11, created on 2013-08-14 23:43:08
         compiled from "phplibs\smarty\templates\edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3155551d9c5be73af37-26991629%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4994e7e4df1911c55006e4e787bf5d2567bda60' => 
    array (
      0 => 'phplibs\\smarty\\templates\\edit.tpl',
      1 => 1376509273,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3155551d9c5be73af37-26991629',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_51d9c5be8fde21_36922473',
  'variables' => 
  array (
    'lang' => 0,
    'change_lang' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51d9c5be8fde21_36922473')) {function content_51d9c5be8fde21_36922473($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ru-RU">
    <head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="/css/nav_menu_<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
.css" />	
	<link rel="stylesheet" type="text/css" href="/css/buy_style.css" />
        <title>Редактор информации</title>
	<script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.cookie.js" ></script>	

    

<!-- Скрипт отвечающий за клик на header Kristina Strunkova-->
	<script type="text/javascript">
	    $(document).ready(function(){	     
		$('#header_name').bind('click',headerNameClickHandler);
	     });
	    function headerNameClickHandler() {
                $.cookie("greetingWasShown", null);
		 window.location =  'about.php';		
	    }
	</script>
<!-- Конец. Скрипт отвечающий за клин на header Kristina Strunkova-->

    </head>
    
    <body>
	<div id="wrap">
	    <div id="header">		
		<div id="header_name">		
		</div><!--end header_name-->
		<div id="nav_menu">		
		    <div id="nav_about">
			<a href="about.php"></a>			
		    </div><!--end nav_about-->
		    <div id="nav_contacts" >
			<a href="contacts.php"></a>			
		    </div><!--end nav_contacts-->
		    <div id="nav_gallary">
			<a href="gallery.php"></a>
		    </div><!--end nav_gallary-->
		    <div id="nav_order" >		
		    </div><!--end nav_order-->		
		</div><!--end nav_menu-->
		<div id=lang_changer><a href="?change_lang=1"><?php echo $_smarty_tpl->tpl_vars['change_lang']->value;?>
</a></div>
	    </div><!--end header-->
	    <div id="main_content">
		<div id="header_shaddow"></div>
		<form action="EditPageController.php" method="POST">
		    
		    Русское наименвание <input type="text" name="ru_desc" value="">
		    Английское наименвание <input type="text" name="eng_desc" value="">
		    
		    <input list="rate">
		    <datalist id="rate">
		     <option value="1">
		     <option value="2">
		     <option value="2">
		    </datalist>
		    <p><input type="submit"></p>
		</form>
						

	    </div><!--end main_content-->
	    <div id="footer">
		<div id="footer_phrase_name"> 	    
		</div><!--end footer_phrase_name-->		
	    </div><!--end footer-->
	</div><!--end wrap-->
    </body>
</html><?php }} ?>
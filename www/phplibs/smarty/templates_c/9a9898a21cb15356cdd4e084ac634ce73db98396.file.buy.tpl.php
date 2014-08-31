<?php /* Smarty version Smarty-3.1.11, created on 2013-08-25 03:59:34
         compiled from "phplibs/smarty/templates/buy.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20626509405219e3965091a5-85068338%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a9898a21cb15356cdd4e084ac634ce73db98396' => 
    array (
      0 => 'phplibs/smarty/templates/buy.tpl',
      1 => 1357420185,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20626509405219e3965091a5-85068338',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'lang' => 0,
    'change_lang' => 0,
    'buy_pic' => 0,
    'buy_pic_price1' => 0,
    'buy_pic_price2' => 0,
    'buy_pic_price3' => 0,
    'buy_portret' => 0,
    'buy_portret_price' => 0,
    'contacts_main_phrase' => 0,
    'contacts_call_comment' => 0,
    'contacts_mail_comment' => 0,
    'contacts_skype_comment' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_5219e3966dd1e7_55876474',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5219e3966dd1e7_55876474')) {function content_5219e3966dd1e7_55876474($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ru-RU">
    <head>
	<link rel="stylesheet" type="text/css" href="/css/nav_menu_<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
.css" />
	<link rel="stylesheet" type="text/css" href="/css/contacts_style.css" />
	
	<!--[if IE]>
	    <link href='http://fonts.googleapis.com/css?family=Bad+Script|Marck+Script&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	    <link href='http://fonts.googleapis.com/css?family=Marck+Script' rel='stylesheet' type='text/css'>		
	    <style>
		.info {
			font-family: 'Marck Script', cursive;		
			/*font-family: Garamond, 'Garamond Premier Pro';*/
			color: black;
			font-size: 17pt;
		}
		
		.head {
			font-family: 'Marck Script';		
			/*font-family: Garamond, 'Garamond Premier Pro';*/
			color: black;
			font-size: 20pt;
		}		
	    </style>
	<![endif]-->	
	<meta charset="utf-8"/>

	
        <title>На заказ</title>
	<script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.cookie.js" ></script>	
        <script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>

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
		    <div id="nav_order" class="active">		
		    </div><!--end nav_order-->		
		</div><!--end nav_menu-->
		<div id=lang_changer><a href="?change_lang=1"><?php echo $_smarty_tpl->tpl_vars['change_lang']->value;?>
</a></div>
	    </div><!--end header-->
	    <div id="main_content">
		<div id="header_shaddow"></div>
		<div id="contacts_table">
		    <table border=0>
			<tr><td colspan=2><hr></td></tr>
			<tr><td colspan=2 class="head" ><?php echo $_smarty_tpl->tpl_vars['buy_pic']->value;?>
</td></tr>
			<tr><td colspan=2 height=10></td></tr>
			<tr><td ><img src="../images/buy/star_1_32.png"/></td><td class="info" align="left"> <?php echo $_smarty_tpl->tpl_vars['buy_pic_price1']->value;?>
</td></tr>
			<tr><td><img src="../images/buy/star_2_32.png"/></td><td class="info" align="left"> <?php echo $_smarty_tpl->tpl_vars['buy_pic_price2']->value;?>
</td></tr>
			<tr><td><img src="../images/buy/star_3_32.png"/></td><td class="info" align="left"> <?php echo $_smarty_tpl->tpl_vars['buy_pic_price3']->value;?>
</td></tr>
			<tr><td colspan=2 height=40></td></tr>
			<tr><td colspan=2><hr></td></tr>
			<tr><td colspan=2  class="head" ><?php echo $_smarty_tpl->tpl_vars['buy_portret']->value;?>
 </td></tr>			
			<tr><td colspan=2 height=10></td></tr>
			<tr><td ><img src="../images/buy/sketch1.png"/><img src="../images/buy/sketch2.png"/><img src="../images/buy/sketch3.png"/></td><td class="info" align="left"> <?php echo $_smarty_tpl->tpl_vars['buy_portret_price']->value;?>
</td></tr>
		    </table>						
		    
		    
		    <!--table border=0>
		      <tr><td colspan=2 class="head"><?php echo $_smarty_tpl->tpl_vars['contacts_main_phrase']->value;?>
</td></tr>
		      <tr  class="empty"><td   rowspan=3  width=100 ><img  src="../images/contacts/phone.png"/></td><td></td></tr>
		      <tr><td class="info">+7(926)-033-39-31</td></tr>
		      <tr><td class="comment"><?php echo $_smarty_tpl->tpl_vars['contacts_call_comment']->value;?>
</td></tr>
		      
		      <tr  class="empty"><td rowspan=3 ><a class="container" href="mailto:kristina-8989@mail.ru"><img src="../images/contacts/mail.png"/></a></td><td></td></tr>
		      <tr><td class="info"><a href="mailto:kristina-8989@mail.ru">kristina-8989@mail.ru</a></td></tr>
		      <tr><td class="comment"><?php echo $_smarty_tpl->tpl_vars['contacts_mail_comment']->value;?>
</td></tr>

		      <tr  class="empty"><td rowspan=3><a class="container" href="skype:kristina_551?call"><img  src="../images/contacts/skype.png"/></a></td><td></td></tr>
		      <tr><td class="info"><a href="skype:kristina_551?call">kristina_571</a></td></tr>
		      <tr><td class="comment"><?php echo $_smarty_tpl->tpl_vars['contacts_skype_comment']->value;?>
</td></tr>
    
		    </table>			    
		</div><!--end contacts_table-->
	    </div><!--end main_content-->
	    <div id="footer">
		<div id="footer_phrase_name"> 	    
		</div><!--end footer_phrase_name-->		
	    </div><!--end footer-->
	</div><!--end wrap-->
    </body>
</html><?php }} ?>
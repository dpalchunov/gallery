<?php /* Smarty version Smarty-3.1.11, created on 2013-01-02 03:35:41
         compiled from "phplibs\smarty\templates\about.tpl" */ ?>
<?php /*%%SmartyHeaderCode:966550be5635e022e6-26589785%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '616d4e40cacd9e25482ea0855895e4cf6fe29487' => 
    array (
      0 => 'phplibs\\smarty\\templates\\about.tpl',
      1 => 1357083336,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '966550be5635e022e6-26589785',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.11',
  'unifunc' => 'content_50be56363a5422_99017109',
  'variables' => 
  array (
    'lang' => 0,
    'greetingClass' => 0,
    'change_lang' => 0,
    'main_text' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_50be56363a5422_99017109')) {function content_50be56363a5422_99017109($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ru-RU">
    <head>
	<link rel="stylesheet" type="text/css" href="/css/nav_menu_<?php echo $_smarty_tpl->tpl_vars['lang']->value;?>
.css" />
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
	
	<!--[if IE]>
	    <link href='http://fonts.googleapis.com/css?family=Bad+Script|Marck+Script&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	    <link href='http://fonts.googleapis.com/css?family=Marck+Script' rel='stylesheet' type='text/css'>		
	    <style>
		#main_text pre {
			font-family: 'Marck Script', cursive;		
			/*font-family: Garamond, 'Garamond Premier Pro';*/
			color: black;
			font-size: 17pt;
		}		
	    </style>
	<![endif]-->	
	<meta charset="utf-8"/>

	
        <title>О ней</title>
	<script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery.cookie.js" ></script>	

<!--Скрпты отвечающие за слайдер аватарок на главной странице-->	
	<script type="text/javascript">
	//объявляем глобальные переменные
	//количество фотографий , которые можно перебирать на аватарке
	avaCount = 4;
	//время анимации смены аватарки
	animateTime = 120;
	</script>	
	
	<script type="text/javascript">
	    $(document).ready(function(){	     
		$("#right_ar").click(function(){
		    //берем адрес текущей картинки и увеличиваем в адресе лишь индекс
		    //.replace(/"/g,'') убирает двойные кавычки, потому что разные браузеры то ставят их то нет
		    var avaPath = $("#ava").css("background-image").replace(/"/g,'');
		    var avaPathWhithoutIndex = avaPath.substring(0,avaPath.length-6);
		    var avaIndex = avaPath.substring(avaPath.length-6,avaPath.length-5);
		    //проверям не дошли ли мы до конца наших аватарок
		    if (avaIndex==avaCount) {
			var nextAvaIndex = 1;	
		    } else {
			var nextAvaIndex = 1 + parseInt(avaIndex);			
		    }
		    var nextAvaPath = avaPathWhithoutIndex + nextAvaIndex + ".jpg)";
		    //привязка дива с авой к правому краю(чтобы ехал в право), ну  тени тоже
		    $("#ava").css("left","")
		    $("#ava").css("right","75px")
		    $("#shaddow").css("left","")
		    $("#shaddow").css("right","75px")		    
		    //сначала убираем DIV
		    $("#ava").animate({width: 'toggle'},
				      animateTime,
				      function () {
					//по окончании анимации исчезновения
					//установка нового background-image
					$("#ava").css("background-image",nextAvaPath);
					//привязка дива с авой к левому краю
					$("#ava").css("right","")
					$("#ava").css("left","68px");					
				      }				      
				    );
		    //прячем тень
		    $("#shaddow").animate({opacity: 'hide'},animateTime);		    
		    //показываем DIV заново
		    $("#ava").animate({width: 'toggle'},animateTime);
		    //показываем тень
		    $("#shaddow").animate({opacity: 'show'},animateTime);
		});	      
	     });
	</script>
	
	<script type="text/javascript">
	    $(document).ready(function(){	     
		$("#left_ar").click(function(){	    
		    //берем адрес текущей картинки и увеличиваем в адресе лишь индекс
		    //.replace(/"/g,'') убирает двойные кавычки, потому что разные браузеры то ставят их то нет
		    var avaPath = $("#ava").css("background-image").replace(/"/g,'');
		    var avaPathWhithoutIndex = avaPath.substring(0,avaPath.length-6);
		    var avaIndex = avaPath.substring(avaPath.length-6,avaPath.length-5);
		    //проверям не дошли ли мы до начала наших аватарок
		    if (avaIndex==1) {
			var nextAvaIndex = avaCount;	
		    } else {
			var nextAvaIndex = parseInt(avaIndex) - 1;			
		    }
		    var nextAvaPath = avaPathWhithoutIndex + nextAvaIndex + ".jpg)";
		    //привязка дива с авой к лувому краю(чтобы ехал в влево)
		    $("#ava").css("right","");
		    $("#ava").css("left","68px");
		    //сначала убираем DIV
		    $("#ava").animate({width: 'toggle'},
				      animateTime,
				      function () {
					//по окончании анимации исчезновения
					//установка нового background-image
					$("#ava").css("background-image",nextAvaPath);
					//привязка дива с авой к правому краю(чтобы выезжал справа)
					$("#ava").css("left","");
					$("#ava").css("right","75px");
				      }				      
				    );
		    //прячем тень
		    $("#shaddow").animate({opacity: 'hide'},animateTime);		    
		    //показываем DIV заново
		    $("#ava").animate({width: 'toggle'},animateTime);
		    //показываем тень
		    $("#shaddow").animate({opacity: 'show'},animateTime);		    
		});	      
	     });
	</script>
<!--Конец скрптов отвечающих за слайдер аватарок на главной странице-->	

<!-- Скрипт отвечающий для страничку приветствия, которая отображается один раз при первом посещении сайта-->
	<script type="text/javascript">
	    $(document).ready(function(){	     
		$('#greeting_img').bind('click',greetingClickHandler);
                $.cookie("greetingWasShown", "true");		
	     });
	    function greetingClickHandler() {
		$('#greeting').fadeOut(400);
	    }
	    
	</script>
<!-- Конец. Скрипт отвечающий для страничку приветствия, которая отображается один раз при первом посещении сайта-->
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
	    <div  id="greeting" <?php echo $_smarty_tpl->tpl_vars['greetingClass']->value;?>
>
		<img id="greeting_img" src="images/greeting.png">
	    </div>	    
	    <div id="header">		
		<div id="header_name">		
		</div><!--end header_name-->
		<div id="nav_menu">		
		    <div id="nav_about" class="active">		
		    </div><!--end nav_about-->
		    <div id="nav_contacts">
			<a href="contacts.php"></a>			
		    </div><!--end nav_contacts-->
		    <div id="nav_gallary">
			<a href="gallery.php"></a>
		    </div><!--end nav_gallary-->
		    <div id="nav_order">
			<a href="buy.php"></a>				
		    </div><!--end nav_order-->		
		</div><!--end nav_menu-->
		<div id=lang_changer><a href="?change_lang=1"><?php echo $_smarty_tpl->tpl_vars['change_lang']->value;?>
</a></div>
	    </div><!--end header-->
	    <div id="main_content"><!--[if IE]><div id="main_ie_gradient"><![endif]-->
		<div id="header_shaddow"></div>
		<div id="slider">
		    <div id="left_ar"></div>
		    <div id="ava"></div>		    
		    <div id="right_ar"></div>
		    <div id="shaddow"></div>			    
		</div><!--end slider-->
		<div id="main_text">
		    <pre><?php echo $_smarty_tpl->tpl_vars['main_text']->value;?>
</pre>		
		</div><!--end main_text-->    
	    <!--[if IE]></div><![endif]--></div><!--end main_content-->
	    <div id="footer">
		<div id="footer_phrase_name"> 	    
		</div><!--end footer_phrase_name-->		
	    </div><!--end footer-->
	</div><!--end wrap-->
    </body>
</html><?php }} ?>
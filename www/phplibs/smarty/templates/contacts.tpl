<!DOCTYPE html>
<html lang="ru-RU">
    <head>
	<link rel="stylesheet" type="text/css" href="/css/nav_menu_{{{$lang}}}.css" />
	<link rel="stylesheet" type="text/css" href="/css/contacts_style.css" />
	
	<!--[if IE]>
	    <link href='http://fonts.googleapis.com/css?family=Bad+Script|Marck+Script&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	    <link href='http://fonts.googleapis.com/css?family=Marck+Script' rel='stylesheet' type='text/css'>		
	    <style>
		.head {
			font-family: 'Marck Script', cursive;		
			/*font-family: Garamond, 'Garamond Premier Pro';*/
			color: black;
			font-size: 20pt;
		}
		.info {
			font-family: 'Marck Script', cursive;		
			/*font-family: Garamond, 'Garamond Premier Pro';*/
			color: black;
			font-size: 20pt;
		}
		.info a {
			font-family: 'Marck Script', cursive;		
			/*font-family: Garamond, 'Garamond Premier Pro';*/
			color: black;
			font-size: 20pt;
		}		
		.comment {
			font-family: 'Marck Script', cursive;		
			/*font-family: Garamond, 'Garamond Premier Pro';*/
			color: black;
			font-size: 12pt;
		}		
	    </style>
	<![endif]-->	
	<meta charset="utf-8"/>

	
        <title>Контакты</title>
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
		    <div id="nav_contacts" class="active">		
		    </div><!--end nav_contacts-->
		    <div id="nav_gallary">
			<a href="gallery.php"></a>
		    </div><!--end nav_gallary-->
		    <div id="nav_order">
			<a href="buy.php"></a>				
		    </div><!--end nav_order-->		
		</div><!--end nav_menu-->
		<div id=lang_changer><a href="?change_lang=1">{{{$change_lang}}}</a></div>
	    </div><!--end header-->
	    <div id="main_content">
		<div id="header_shaddow"></div>
		<div id="contacts_table">
		    <table border=0>
		      <tr><td colspan=2 class="head">{{{$contacts_main_phrase}}}</td></tr>
		      <tr><td colspan=2 height=20></td></tr>		      
		      <tr  class="empty"><td   rowspan=3  width=100 ><img  src="../images/contacts/phone.png"/></td><td></td></tr>
		      <tr><td class="info">+7(926)-033-39-31</td></tr>
		      <tr><td class="comment">{{{$contacts_call_comment}}}</td></tr>
		      
		      <tr  class="empty"><td rowspan=3 ><a class="container" href="mailto:kristina-8989@mail.ru"><img src="../images/contacts/mail.png"/></a></td><td></td></tr>
		      <tr><td class="info"><a href="mailto:kristina-8989@mail.ru">kristina-8989@mail.ru</a></td></tr>
		      <tr><td class="comment">{{{$contacts_mail_comment}}}</td></tr>

		      <tr  class="empty"><td rowspan=3><a class="container" href="skype:kristina_551?call"><img  src="../images/contacts/skype.png"/></a></td><td></td></tr>
		      <tr><td class="info"><a href="skype:kristina_551?call">kristina_571</a></td></tr>
		      <tr><td class="comment">{{{$contacts_skype_comment}}}</td></tr>
    
		    </table>			    
		</div><!--end contacts_table-->
	    </div><!--end main_content-->
	    <div id="footer">
		<div id="footer_phrase_name"> 	    
		</div><!--end footer_phrase_name-->		
	    </div><!--end footer-->
	</div><!--end wrap-->
    </body>
</html>
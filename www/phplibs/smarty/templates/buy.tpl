<!DOCTYPE html>
<html lang="ru-RU">
    <head>
	<link rel="stylesheet" type="text/css" href="/css/nav_menu_{{{$lang}}}.css" />
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
		<div id=lang_changer><a href="?change_lang=1">{{{$change_lang}}}</a></div>
	    </div><!--end header-->
	    <div id="main_content">
		<div id="header_shaddow"></div>
		<div id="contacts_table">
		    <table border=0>
			<tr><td colspan=2><hr></td></tr>
			<tr><td colspan=2 class="head" >{{{$buy_pic}}}</td></tr>
			<tr><td colspan=2 height=10></td></tr>
			<tr><td ><img src="../images/buy/star_1_32.png"/></td><td class="info" align="left"> {{{$buy_pic_price1}}}</td></tr>
			<tr><td><img src="../images/buy/star_2_32.png"/></td><td class="info" align="left"> {{{$buy_pic_price2}}}</td></tr>
			<tr><td><img src="../images/buy/star_3_32.png"/></td><td class="info" align="left"> {{{$buy_pic_price3}}}</td></tr>
			<tr><td colspan=2 height=40></td></tr>
			<tr><td colspan=2><hr></td></tr>
			<tr><td colspan=2  class="head" >{{{$buy_portret}}} </td></tr>			
			<tr><td colspan=2 height=10></td></tr>
			<tr><td ><img src="../images/buy/sketch1.png"/><img src="../images/buy/sketch2.png"/><img src="../images/buy/sketch3.png"/></td><td class="info" align="left"> {{{$buy_portret_price}}}</td></tr>
		    </table>						
		    
		    
		    <!--table border=0>
		      <tr><td colspan=2 class="head">{{{$contacts_main_phrase}}}</td></tr>
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
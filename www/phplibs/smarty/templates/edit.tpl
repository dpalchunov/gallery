<!DOCTYPE html>
<html lang="ru-RU">
    <head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="/css/nav_menu_{{{$lang}}}.css" />	
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
		<div id=lang_changer><a href="?change_lang=1">{{{$change_lang}}}</a></div>
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
</html>
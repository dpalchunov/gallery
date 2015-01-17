
	<link rel="stylesheet" type="text/css" href="/css/nav_menu.css" />
	<link rel="stylesheet" type="text/css" href="/css/buy_style.css" />
	<link rel="stylesheet" type="text/css" href="/css/header.css" />

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
    <script type="text/javascript" src="js/header.js"></script>


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
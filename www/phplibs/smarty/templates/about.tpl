<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <link rel="stylesheet" type="text/css" href="/css/nav_menu_{{{$lang}}}.css"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>

    <!--[if IE]>
    <link href='http://fonts.googleapis.com/css?family=Bad+Script|Marck+Script&subset=latin,cyrillic' rel='stylesheet'
          type='text/css'>
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

    <script type="text/javascript">
        var avas =
        {{{$avas}}}
    </script>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/about.js"></script>
</head>

<body>
<div id="header">
    <div id="header_name">
        Kristina Strunkova
    </div>
    <!--end header_name-->
    <div id="nav_menu">
        <div id="nav_about" class="active">
        </div>
        <!--end nav_about-->
        <div id="nav_contacts">
            <a href="contacts.php"></a>
        </div>
        <!--end nav_contacts-->
        <div id="nav_gallary">
            <a href="gallery.php"></a>
        </div>
        <!--end nav_gallary-->
        <div id="nav_order">
            <a href="buy.php"></a>
        </div>
        <!--end nav_order-->
    </div>
    <!--end nav_menu-->
    <div id=lang_changer><a href="?change_lang=1">{{{$change_lang}}}</a></div>
</div>
<!--end header-->
<div id="wrap">
    <div id="greeting" {{{$greetingClass}}}>
        <img id="greeting_img" src="images/greeting.png">
    </div>
    <div id="main_content">
        <div id="slider">
            <div id="ava"><img id="ava_img"/></div>
        </div>
        <!--end slider-->
        <div id="main_text">
            <pre>{{{$main_text}}}</pre>
        </div>
        <!--end main_text-->
        <!--[if IE]></div><![endif]--></div>
    <!--end main_content-->
    <div id="footer">
        <div id="footer_phrase_name">
        </div>
        <!--end footer_phrase_name-->
    </div>
    <!--end footer-->
</div>
<!--end wrap-->
</body>
</html>
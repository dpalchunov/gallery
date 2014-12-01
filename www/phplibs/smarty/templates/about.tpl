<!DOCTYPE html>
{{{$meta}}}
<html lang="ru-RU">
<head>
    <link rel="stylesheet" type="text/css" href="/css/nav_menu.css"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="/css/header.css"/>

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
<div id="greeting" {{{$greetingClass}}}>
    <img id="greeting_img" src="images/greeting.png">
</div>
{{{$header}}}
<div id="wrap">

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
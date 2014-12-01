<!DOCTYPE html>
{{{$meta}}}
<html lang="ru-RU">
<head>
    <link rel="stylesheet" type="text/css" href="/css/header.css"/>
    <link rel="stylesheet" type="text/css" href="/css/nav_menu.css"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>

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
<div id="wrapper" {{{$wrapper_class}}}>
{{{$header}}}
    <div id="main_content">
            <div id="ava"><img id="ava_img"/></div>
            <div id="main_text">
            <pre>{{{$main_text}}}</pre>
        </div>
    </div>
    <!--end main_content-->
    <div id="footer">
        <div id="footer_phrase_name">
        </div>
        <!--end footer_phrase_name-->
    </div>


</div>
</body>
</html>
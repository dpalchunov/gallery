<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <link rel="stylesheet" type="text/css" href="/css/nav_menu_eng.css"/>
    <link rel="stylesheet" type="text/css" href="/css/admin_menu.css"/>
    <link rel="stylesheet" type="text/css" href="/css/classificator_edit_style.css"/>
    <link rel="stylesheet" type="text/css" href="/css/cropper.css">
    <link rel="stylesheet" type="text/css" href="/css/uploadfile.css">
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.css">


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


    <title>Edit gallery</title>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/cropper.js"></script>
    <script type="text/javascript" src="js/classificator_edit.js"></script>
    <script type="text/javascript" src="js/jquery.uploadfile.js"></script>

</head>


<body>
<div id="dialog" title=""></div>
<div id="wrap">
    <div id="header">
        <div id="header_name">
        </div>
        <!--end header_name-->
        <div id="nav_menu">
            <div id="nav_about">
            </div>
            <!--end nav_about-->
            <div id="nav_contacts">
                <a href="contacts.php"></a>
            </div>
            <!--end nav_contacts-->
            <div id="nav_gallary">
                <a href="gallery.php" class="active"></a>
            </div>
            <!--end nav_gallary-->
            <div id="nav_order">
                <a href="buy.php"></a>
            </div>
            <!--end nav_order-->
        </div>
        <!--end nav_menu-->
        <div id="admin_menu">
            <div id="classification_edit">
                <a href="classificator_edit.php" class="active">Classification editor</a>
            </div>
            <div id="gallery_edit">
                <a href="gallery_edit.php">Gallery editor</a>
            </div>
            <div id="about_edit">
                <a href="about_edit.php">About editor</a>
            </div>
        </div>
        <!--end admin_menu-->
    </div>
    <!--end header-->
    <div id="gallery_editor_content"><!--[if IE]>
        <div id="main_ie_gradient"><![endif]-->
        <div id="header_shaddow"></div>

        <div id="classificators">
            {{{$classificator}}}
            <hr>
        </div>
        <!-- end of persisted-->

        <hr>

        <!--[if IE]></div><![endif]--></div>
    <!--end about_editor_content-->

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
<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <link rel="stylesheet" type="text/css" href="/css/nav_menu_{{{$lang}}}.css" />
    <link rel="stylesheet" type="text/css" href="/css/about_edit_style.css" />
    <link rel="stylesheet" type="text/css" href="/css/cropper.css">

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


    <title>Edit about info</title>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js" ></script>
    <script type="text/javascript" src="js/cropper.js"></script>
    <script type="text/javascript" src="js/about_edit.js"></script>

</head>


<body>
<div id="wrap">
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
        <div id=lang_changer><a href="?change_lang=1">{{{$change_lang}}}</a></div>
    </div><!--end header-->
    <div id="about_editor_content"><!--[if IE]><div id="main_ie_gradient"><![endif]-->
        <div id="header_shaddow"></div>
        <div id="add_new">
            <div id="add_new_controls" class="controls green">
                <a href="" >+ upload more</a>
            </div>

        </div><!-- end of add_new-->
        <div id="persisted" >
            <div class="persisted">
                <div class="image" style=" background-image: url(http://localhost:8080/images/slider/ava1.jpg);"></div>
                <div class="persisted_img_controls controls"><div class="remove"><a href="" > remove</a></div></div>
            </div>
            <div class="persisted">
                <div class="image" style=" background-image: url(http://localhost:8080/images/slider/ava2.jpg);"></div>
                <div class="persisted_img_controls controls"><div class="remove"><a href="" > remove</a></div></div>
            </div>
            <div class="persisted">
                <div class="image" style="background-image: url(http://localhost:8080/images/slider/ava3.jpg); "></div>
                <div class="persisted_img_controls controls"><div class="remove"><a href="" > remove</a></div></div>
            </div>
            <div class="persisted">
                <div class="image" style="background-image: url(http://localhost:8080/images/slider/ava4.jpg); "></div>
                <div class="persisted_img_controls controls"><div class="remove"><a href="" > remove</a></div></div>
            </div>

            {{{$persisted_pictures}}}
        </div><!-- end of persisted-->
        <div id="uploaded">
            <div class="uploaded">
                <div class="cropper_div"> <img class="cropper_img" src="../../../images/slider/ava4.jpg"> </div>
                <div class="image cropper-preview" style="background-image: url(http://localhost:8080/images/slider/ava4.jpg); "></div>
                <div class="uploaded_img controls"><div class="red"><a href=""> crop&save </a><a href=""> cancel</a></div></div>
            </div>
        </div><!-- end of uploaded-->
        <div id="add_new">
            <div id="add_new_controls" class="controls green">
                <a href="" >+ upload more</a>
            </div>

        </div><!-- end of add_new-->
    <!--[if IE]></div><![endif]--></div><!--end about_editor_content-->
    <div id="footer">
        <div id="footer_phrase_name">
        </div><!--end footer_phrase_name-->
    </div><!--end footer-->
</div><!--end wrap-->
</body>
</html>
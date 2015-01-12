<!DOCTYPE html>
{{{$meta}}}
<html lang="ru-RU">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="/css/nav_menu.css"/>
    <link rel="stylesheet" type="text/css" href="/css/gallary_style.css"/>
    <link rel="stylesheet" type="text/css" href="/css/header.css"/>
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.css">

    <title>Галерея</title>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/jquery.tabSlideOut.js"></script>
    <script type="text/javascript" src="js/gallery.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>


    <!-- Скрипт отвечающий за клик на header Kristina Strunkova-->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#header_name').bind('click', headerNameClickHandler);
        });
        function headerNameClickHandler() {
            $.cookie("greetingWasShown", null);
            window.location = 'about.php';
        }
    </script>
    <!-- Конец. Скрипт отвечающий за клин на header Kristina Strunkova-->

</head>

<body>
<div class="fullScreenGallery">
    <div id="fullScreenGalleryLeftSide" class="fullScreenGalleryNaviButton"></div>
    <div id="fullScreenPicContanier">

    </div>
    <div id="fullScreenGalleryRightSide" class="fullScreenGalleryNaviButton"></div>
</div>
<div id="arrow_pic">
    <br>
</div>
{{{$header}}}
<div id="all_space_wrap">
    <div id="left_column_wrap">
        <a href="#top"></a>
    </div>
    <div id="left-trans-window"></div>
    <div id="page_wrap">
        <div id="page_wrap_padding"></div>
        <div id="main_content">
            <div id="header_shaddow"></div>
            <div id="sketches"></div>
        </div>
        <!--end main_content-->
        <div id="footer">
            <div id="footer_phrase_name">
            </div>
            <!--end footer_phrase_name-->
        </div>
        <!--end footer-->
    </div>
    <!--end page_wrap-->
</div>
<!--end all_space_wrap-->
</body>
</html>
<!DOCTYPE html>
<html lang="ru-RU">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="/css/nav_menu_{{{$lang}}}.css"/>
    <link rel="stylesheet" type="text/css" href="/css/gallary_style.css"/>
    <title>Галерея</title>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/jquery.tabSlideOut.js"></script>
    <script type="text/javascript" src="js/gallery.js"></script>


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
<div id="header">
    <div id="header_name">
        KRISTINA STRUNKOVA
    </div>
    <!--end header_name-->
    <div id="nav_menu">
        <div id="nav_about">
            <a href="about.php"></a>
        </div>
        <!--end nav_about-->
        <div id="nav_contacts">
            <a href="contacts.php"></a>
        </div>
        <!--end nav_contacts-->
        <div id="nav_gallary" class="active">
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
<div id="all_space_wrap">
    <div id="left_column_wrap">
        <a href="#top"></a>
    </div>
    <div id="left-trans-window"></div>
    <div id="page_wrap">
        <div id="page_wrap_padding"></div>
        <div id="main_content">
            <div id="header_shaddow"></div>
            <div id="sketches_table_wrap">
                <table id="sketches_table">
                    <tbody id="sketches_table_body"></tbody>
                </table>
            </div>
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
<div class="panel">
    <div class="panelButton"></div>
    <div id="classificators">{{{$classificators}}}</div>
</div>
</body>
</html>
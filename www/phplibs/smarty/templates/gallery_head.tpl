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
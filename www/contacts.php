<?php
    require_once 'phplibs/ResourceService.php';
    $contactsPage = new ContactsPageViewer();
    $contactsPage -> show($_POST);
?>
<?php

preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
if(count($matches)<2){
    preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
}

if (count($matches)>1){
    //Then we're using IE
    $version = $matches[1];

    switch(true){
        case ($version<=8):
            //IE 8 or under!
            echo 'go away';
            break;

        case ($version==9 || $version==10):
            echo 'i am ok with you';
            break;

        case ($version==11):
            echo 'i am ok with you';
            break;

        default:
            echo 'i am ok with you';
    }
}

?>
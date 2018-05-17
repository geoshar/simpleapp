<?php

// require parse library
require_once('funtions.php');

// find links on both sites, and compare,
// returning an array with objects of @link1 @link2 @percentage
function findAndCompare($link1, $link2){
    // get all the links on both sites
    $linksPage1 = getHrefLinks($link1);
    $linksPage2 = getHrefLinks($link2);
    // comparation
    $result = compareLinks($linksPage1, $linksPage2);
    return $result;
}

$link1 = (isset($_GET['link1']) AND !empty($_GET['link1'])) ? $_GET['link1'] : false;
$link2 = (isset($_GET['link2']) AND !empty($_GET['link2'])) ? $_GET['link2'] : false;
$download = (isset($_GET['download'])) ? true  : false;

if($link1 AND $link2){
    $output = findAndCompare($link1, $link2);
    if($download){
        include_once('download.php');
    }
}else{
    $output = false;
}

include_once('simpleapp.html.php');

?>
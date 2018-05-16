<?php

// require parse library
require_once('simple_html_dom.php');

// returns an array with all links reffered on the same domain name
function getHrefLinks($selector, $link){
    $result = [];
    foreach ($selector as $item) {
        $parsedUrl = parse_url($link);

        if(strpos($item->href, $parsedUrl['host']) AND !in_array($item->href, $result)){

            $result[] = $item->href;
        }
    }
    return $result;
}

// find links on both sites, and compare,
// returning an array with objects of @link1 @link2 @percentage
function findAndCompare($link1, $link2){
    $page1 = file_get_html($link1);
    $page2 = file_get_html($link2);
    // get all the links on both sites
    $linksPage1 = getHrefLinks($page1->find('a'), $link1);
    //die(print_r($linksPage1));
    $linksPage2 = getHrefLinks($page2->find('a'), $link2);
    // comparation
    $result = [];
    foreach ($linksPage1 as $href1){
        $percentSimilarity = [];
        $percentages = [];
        foreach($linksPage2 as $href2){
                $parseUrl1 = parse_url($href1);
                $path1 = isset($parseUrl1['path']) ? $parseUrl1['path']: ' ';

                $parseUrl2 = parse_url($href2);
                $path2 = isset($parseUrl2['path']) ? $parseUrl2['path']: ' ';
                // compare
                similar_text($path1, $path2, $percent);
                $percentSimilarity[] = [$href1, $href2, $percent];
                $percentages[] = $percent;
             }
        array_multisort($percentages, SORT_DESC, $percentSimilarity);
        $result[] = [$href1, $percentSimilarity[0][1], round($percentSimilarity[0][2], 2). '%'];
    }
    return $result;
}

$link1 = (isset($_GET['link1']) AND !empty($_GET['link1'])) ? $_GET['link1'] : false;
$link2 = (isset($_GET['link2']) AND !empty($_GET['link2'])) ? $_GET['link2'] : false;
$download = (isset($_GET['download'])) ? true  : false;
if($link1 AND $link2){
    $output = findAndCompare($link1, $link2);

    // download the file
    if($download) {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="linksComparation.'.date("H:i:s").'.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $file = fopen('php://output', 'w');

        fputcsv($file, array('domain 1', 'domain 2', 'percentage'));

        foreach ($output as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
        exit();
    }
}else{
    $output = false;
}
?>
<html>
<head>

    <style>
        body{
            margin: 30px auto;
            text-align: center;
        }
        .form{
            margin:0 auto;
        }
        .form_container {
            width: 320px;
            margin: 0 auto;
        }
        .form input[type="text"]{
            min-width: 100%;
            display: block;
            margin:4px;
        }
        .form .button{
            margin:4px;
        }
        .form .output{
            text-align:left;
            padding:20px;
        }
        .form .output .item a{
            display:inline-block;
        }
    </style>
</head>
<body>
<form class="form" action="index.php">
    <div class="form_container">
        <input type="text" name="link1" placeholder="Link 1" value="<?=$link1?>">
        <input type="text" name="link2" placeholder="Link 2" value="<?=$link2?>">
        <input type="submit" class="button" value="Compare and show">
        <input type="submit" name="download" class="button" value="Compare and download CSV">
    </div>
    <div class="output">
        <?php if($output): ?>
        <?php foreach($output as $item): ?>
            <div class="item"><a href="<?=$item[0]?>"><?=$item[0]?></a>, <a href="<?=$item[1]?>"><?=$item[1]?></a>, <?=$item[2]?></div>
        <?php endforeach ?>
        <?php else: ?>
         no results
        <?php endif?>
    </div>
</form>


</body>
</html>

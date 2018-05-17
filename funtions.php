<?php
/**
 * Created by PhpStorm.
 * User: george
 * Date: 17/05/2018
 * Time: 14:57
 */
// returns an array with all links reffered on the same domain name
require_once('libs/simple_html_dom.php');

function getHrefLinks($link){
    $result = [];
    $selector = file_get_html($link)->find('a');
    foreach ($selector as $item) {
        $parsedUrl = parse_url($link);

        if(strpos($item->href, $parsedUrl['host']) AND !in_array($item->href, $result)){

            $result[] = $item->href;
        }
    }
    return $result;
}
function compareLinks($linksPage1, $linksPage2){
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
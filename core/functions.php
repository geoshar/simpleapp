<?php
/**
 * Created by PhpStorm.
 * User: george
 * Date: 17/05/2018
 * Time: 14:57
 */

// returns an array with all links reffered on the same domain name
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

function compareLinks($linksPage1, $linksPage2, $sort){
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
    // check if need to be sorted
    if($sort) {
        // sort desc all results by percentages
        $resultPercentages = [];
        foreach ($result as $row) {
            $resultPercentages[] = $row[2];
        }
        array_multisort($resultPercentages, SORT_DESC, $result);
    }
    return $result;
}

// find links on both sites, and compare,
// returning an array with objects of @link1 @link2 @percentage
function findAndCompare($link1, $link2, $sort){

    if($link1 AND $link2) {
        // get all the links on both sites
        $linksPage1 = getHrefLinks($link1);
        $linksPage2 = getHrefLinks($link2);
        // comparation
        $result = compareLinks($linksPage1, $linksPage2, $sort);
    }else {
        $result = false;
    }
    return $result;
}
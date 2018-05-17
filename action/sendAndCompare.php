<?php

// get output array of data
$output = findAndCompare($link1, $link2, $sort);
// connect template
include_once(ROOT_DIR.'/view/simpleapp.html.php');

?>
<?php

// define directories
define("ROOT_DIR", __DIR__);
define("ACT_DIR", ROOT_DIR.'/action/');

// connect necessary libs
require_once(ROOT_DIR.'/libs/simple_html_dom.php');

// require necessary core functions
require_once(ROOT_DIR.'/core/functions.php');

// get action query
$action = (isset($_GET['act']) AND !empty($_GET['act'])) ? $_GET['act'] : '';

// get main query keys
$link1 = (isset($_GET['link1']) AND !empty($_GET['link1'])) ? $_GET['link1'] : false;
$link2 = (isset($_GET['link2']) AND !empty($_GET['link2'])) ? $_GET['link2'] : false;
$sort = isset($_GET['sort']) ? $_GET['sort'] : false;

// check for current action
  switch ($action){

      case "download":
          include_once(ACT_DIR.'download.php');
          break;

      case "sendAndCompare":
          include_once(ACT_DIR. 'sendAndCompare.php');
          break;

      default:
          include_once(ACT_DIR. 'sendAndCompare.php');
          break;
  }


?>

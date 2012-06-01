<?php

$action = "";
if (!empty($_GET['action'])) {
  $action = $_GET['action'];
}
$controller = new INPOSTGALLERY_Controller();
switch ($action) {
  case "settings":
	$controller->action_settings();
	break;
    case "languages":
	$controller->action_languages();
	break;
  default:
	$controller->action_index();
	break;
}


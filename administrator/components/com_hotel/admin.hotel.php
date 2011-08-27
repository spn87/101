<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once "controller.php";
require_once "menu.php";
require_once "views/index.php";
$controller = new HotelController();


$controller->execute(JRequest::getCmd("task","index"));
$controller->redirect();

?>
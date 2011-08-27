<?php

defined('_JEXEC') or die('Restricted access');

require_once (JPATH_COMPONENT.DS.'controller.php');
$task=JRequest::getCmd('task');


$controller=new ttbookingController();
$controller->execute($task);
$controller->redirect();

?>
<?php

require_once "controller.php";
if (!JRequest::getCmd("gid") && !JRequest::getCmd("hid"))
{
	echo "Error";
}

$controller = new HotelController();
$controller->execute(JRequest::getCmd("task","index"));

$controller->redirect();

?>
<?php

$task = JRequest::getCmd("task","index");

$subMenus = array(
	'Add Hotel' => 'add');

JSubMenuHelper::addEntry(JText::_( 'Hotels' ), "index.php?option=com_hotel", !in_array( $task, $subMenus));

foreach ($subMenus as $name => $extension) {
	JSubMenuHelper::addEntry(JText::_( $name),"index.php?option=com_hotel&task=".$extension, $extension == $task);
}

?>
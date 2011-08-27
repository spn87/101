<?php

jimport('joomla.application.component.controller');

class ttbookingController extends JController
{
	
	function save()
	{
		
		$model = $this->getModel('ttbooking');

		if ($model->store($post)) {
			$msg = JText::_( 'Booking Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Booking' );
		}

		//Check the table in so it can be edited.... we are done with it anyway
		$link = 'index.php?option=com_ttbooking';
		$this->setRedirect($link, $msg);
	}
}
?>

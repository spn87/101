<?php

jimport( 'joomla.application.component.view');
class ttbookingViewttbooking extends JView
{
	function display($tpl = null)
	{
		$datattbooking = $this->get('ttbooking');
		$this->assignRef( 'booking',	$datattbooking );

		parent::display($tpl);
	}
}
?>

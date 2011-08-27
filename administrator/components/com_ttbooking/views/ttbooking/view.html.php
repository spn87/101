<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class ttbookingsViewttbooking extends JView
{
	function display($tpl = null)
	{
		
$booking		=& $this->get('Data');
		$isNew		= ($booking->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Booking' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('booking',		$booking);

		parent::display($tpl);
	}
}
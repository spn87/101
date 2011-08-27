<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class ttbookingsViewttbookings extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Booking' ), 'generic.png' );
		JToolBarHelper::custom( 'checkin', 'forward.png', 'forward.png', 'Checkin',false,false);
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		JToolBarHelper::custom('show','preview.png','preview.png','View',false,false);
		JToolBarHelper::custom('close','cancel.png' ,'cancel.png' ,'Close',false,false);
		

		// Get data from the model
		$items		= & $this->get('Data');

		$this->assignRef('items',$items);
		parent::display($tpl);
	}
}
<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class ttbookingsViewttbookings extends JView
{
	function display($tpl = null)
	{
	
		$this->assignRef('items',"Check Out");

		parent::display($tpl);
	}
}
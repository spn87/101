<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class ttbookingsViewttbookingcheckouts extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Checkout' ), 'generic.png' );
		JToolBarHelper::custom("delete","delete.png","delete.png","Delete",false,false);
		JToolBarHelper::custom('show','preview.png','preview.png','View',false,false);
		JToolBarHelper::custom("close","cancel.png","cancel.png","Close",false,false);
		
		
		$items= & $this->get('Data');
		$this->assignRef('items',$items);
		
		parent::display($tpl);
	}
}
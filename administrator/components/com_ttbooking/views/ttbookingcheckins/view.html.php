<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class ttbookingsViewttbookingcheckins extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title(JText::_('Checkin'), 'generic.png' );
		JToolBarHelper::custom( 'checkout', 'forward.png', 'forward.png', 'Checkout',false,false);
		JToolBarHelper::custom('delete','delete.png','delete.png','Delete',false,false);
		JToolBarHelper::custom('show','preview.png','preview.png','View',false,false);
		JToolBarHelper::custom('close','cancel.png' ,'cancel.png' ,'Close',false,false);
		$items= & $this->get('Data');
	
		$this->assignRef('items',$items);
		//$this->assignRef('items',"check int");
		parent::display($tpl);
	}
}
<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
class ttbookingsControllerttbookingcheckout extends ttbookingsController
{

	
	
	function __construct()
	{
		parent::__construct();
	}
	function closes(){$this->setRedirect('index.php');}
	function show(){$this->report();}
	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		if(count($cids)==0)
		{
			$this->setRedirect("index.php?option=com_ttbooking&view=ttbookingcheckouts",
			"<font color='red'>".JText::_('cannot delete,must check data!')."</font>");
		}
		else
		{
			$db =& JFactory::getDBO();
			if (count( $cids )) {
				foreach($cids as $cid) 
				{
					$query = "DELETE from jos_ttbooking  WHERE id=$cid"; 
					$db->setQuery($query);
					$db->query();
				}
			}
			$this->setRedirect("index.php?option=com_ttbooking&view=ttbookingcheckouts",JText::_('Delete').count($cids).JText::_('rows'));
		}
	}

}
<?php

defined( '_JEXEC' ) or die( 'Restricted access' );


class ttbookingsControllerttbookingcheckin extends ttbookingsController
{

	function __construct()
	{
		parent::__construct();
		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
	}
	function setId($id)
	{
		$this->_id		= $id;
		$this->_data	= null;
	}
	
	function checkout()
	{
		$dateCheck = JRequest::getVar('datecheck');
		if($dateCheck=="")
		{
			$this->setRedirect("index.php?option=com_ttbooking&view=ttbookingcheckins",
			"<font color='red'>".JText::_('cannot checkout,must select date!')."</font>");
		}
		else
		{
			$db =& JFactory::getDBO();
			
			$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
			if (count( $cids )) {
				foreach($cids as $cid) 
				{
					$query = "UPDATE jos_ttbooking SET act=0,dateaction='$dateCheck' WHERE id=$cid"; 
					$db->setQuery($query);
					$db->query();
				}
			}
			$this->setRedirect("index.php?option=com_ttbooking&view=ttbookingcheckins","Ready checkout!");
		}
	}
	function show()
	{
		$this->report();		
	}
	function delete()
	{
		
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );
		if(count($cids)==0)
		{
			$this->setRedirect("index.php?option=com_ttbooking&view=ttbookingcheckins",
			"<font color='red'>cannot delete,must check data!</font>");
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
			$this->setRedirect("index.php?option=com_ttbooking&view=ttbookingcheckins",JText::_('Delete ').count($cids).JText::_('rows'));
		}
	}

	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_ttbooking&controller=ttbookingcheckins&task=view', $msg );
	}
	function close(){$this->setRedirect('index.php');}
}
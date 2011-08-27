<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.model' );
class ttbookingsModelttbookingcheckouts extends JModel
{

	var $_data;
	function _buildQuery()
	{
		$query = ' SELECT * FROM `jos_ttbooking` where act=0 ';
		return $query;
	}

	function getData()
	{
		if (empty( $this->_data ))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList( $query );
		}

		return $this->_data;
	}
}
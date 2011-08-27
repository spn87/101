	<?php

defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );


class ttbookingModelttbooking extends JModel
{
	function getttbooking()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT * FROM jos_ttbooking';
		$db->setQuery( $query );
		$Data_ttbooking = $db->loadResult();

		return $Data_ttbooking;
	}
	

	function store()
	{	
		
	
		$row =& $this->getTable();

		$data = JRequest::get( 'post' );
		
		$checkArr = array("fullname");
		
		foreach ($checkArr as $c)
		{
			if (!isset($data[$c]) || $data[$c] == "")
			{
				echo "Error";
				return false;
			}
		}
		
		// Bind the form fields to the ttbooking table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the Booking record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}
	
		jimport("phpmailer.phpmailer");
		$mailer = new PHPMailer();
		
		$mailer->Subject = "Booking";
		$mailer->IsHTML(true);
		
		$mailer->AddAddress("abktours-abktours@hotmail.fr","Administrator");
		$mailer->AddAddress("channkrissna@yahoo.com","Administrator");
		$mailer->From = "info@abktours.com";
		$mailer->FromName = "System";
		
		require_once JPATH_ADMINISTRATOR.DS."components".DS."com_ttbooking".DS."controller.php";
		$con = new ttbookingsController();
		
		$bookingData = $con->getBooking($row->id);
		$mailer->Body = $con->getContentView($bookingData);
		if (!$mailer->Send()){}
		
		return true;
	}
}

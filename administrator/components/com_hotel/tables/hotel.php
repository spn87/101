<?php

class TableHotel extends JTable
{
	var $id = null;
	var $g_id = null;
	var $name = null;
	var $max_rate = null;
	var $min_rate = null;
	var $star = null;
	var $description = null;
	var $checkout = null;
	var $checkin = null;
	var $floor_num = null;
	var $rest_num = null;
	var $room_num = null;
	var $built = null;
	var $parking_service = null;
	var $s24 = null;
	var $room_volt = null;
	var $image = null;
	
	function __construct(&$db)
	{
		parent::__construct( '#__hotel', 'id', $db );
	}
}
?>
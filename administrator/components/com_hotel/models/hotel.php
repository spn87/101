<?php

jimport("joomla.application.component.model");

class HotelModelHotel extends JModel
{
	public function getHotelGroup()
	{
		$this->_db->setQuery("select * from #__hotel_group");
		
		$r = $this->_db->loadObjectList();
		
		return $r;
	}
	
	public function getHotels($gId = null,$hotelId = null)
	{
		$query = "SELECT h.*, g.name as gname FROM #__hotel as h INNER JOIN #__hotel_group as g ON h.g_id=g.id";
		
		$where = "";
		if ($gId != null)
			$where .= " h.g_id='$gId'";
		if ($hotelId != null)
			$where .= " h.id='$hotelId'";
		if ($where != "")
			$where = " WHERE".$where;
		
		$query .= $where;
			
		$this->_db->setQuery($query);
			
		if ($hotelId == null)
			return $this->_db->loadObjectList();
		else
			return $this->_db->loadAssoc();
	}
	
	public function getHotel($id=null)
	{
		$data = array();
		
		if ($id ==null)
		{
			$data["name"] = '';
			$data["max_rate"] = 0;
			$data["min_rate"] = 0;
			$data["star"] = 1;
			$data["description"] = "";
			$data["checkout"] = $data["checkin"] =  $data["built"] = "";
			$data["floor_num"] = $data["rest_num"] = $data["room_num"] = 0;
			$data["parking_service"] =  $data["s24"] = "yes";
			$data["room_volt"] = "220";
			
			
		}else
		{
			
			$data = $this->getHotels(null,$id);
		}
		
		return $data;
	}
	
	public function save($data)
	{
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_recipes'.DS.'tables');
		$table = & $this->getTable('hotel');
		
		if(!$table->bind($data))
			JError::raiseError(500, $data->getError() );
		if(!$table->store())
			JError::raiseError(500, $data->getError() );
			
		return true;
	}
	
	public function delete($id)
	{
		JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_recipes'.DS.'tables');
		$table = & $this->getTable('hotel');
		$table->delete($id);
	}
}

?>

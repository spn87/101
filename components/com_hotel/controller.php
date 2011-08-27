<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport("joomla.application.component.controller");

class HotelController extends JController
{
	public function index()
	{
		$gid = JRequest::getCmd("gid",0);
		$db = &JFactory::getDBO();
		$query = "SELECT h.*, g.name as gname FROM #__hotel as h INNER JOIN #__hotel_group as g ON g.id=h.g_id AND g.id=$gid";
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		
		?>		
		<table class="hotel-grid">
			<thead>
				<tr>
					<th>No</th>
					<th><?php echo JText::_('HOTEL')?></th>
					<th>Star</th>
					<th></th>
					
				</tr>
			</thead>
			<tbody>
			<?php
			$i =0; 
			foreach ($rows as $row):?>
				<tr>
					<td><?php echo ++$i;?></td>
					<td><?php echo $row->name?></td>
					<td>
						<?php for($j = 1; $j <= $row->star; $j++):?>
						<img src="images/star.png" width="10px" />
						<?php endfor;?>
					</td>
					
					<td><a href="index.php?option=com_hotel&hid=<?php echo $row->id?>&Itemid=13&task=hotel"><?php echo JText::_('ABK_DETAIL')?></a></td>
				</tr>
			<?php endforeach;?>
			</tbody>
			
		</table>
		<style>
		table.hotel-grid {width: 100%;}
		table.hotel-grid tr td:first-child,table.hotel-grid tr th:first-child {text-align:center; width: 10%;}
		table.hotel-grid tr td,table.hotel-grid tr th {border:1px solid #ccc;}
		table.hotel-grid tr th {background:#eee;}
		table.hotel-grid tbody tr:hover {background:#eee;}
		</style>
		<?php		
	}
	
	public function hotel()
	{
		$id = JRequest::getCmd("hid",0);
		$db = &JFactory::getDBO();
		$query = "SELECT h.*, g.name as gname FROM #__hotel as h INNER JOIN #__hotel_group as g ON g.id=h.g_id AND h.id=$id";
		
		$db->setQuery($query);
		$row = $db->loadObject();
		
		?>
		<h1><?php echo $row->gname;?></h1>
		<div><h2><?php echo $row->name?></h2></div>
		<div style="text-align:center;	">
			<?php if ($row->image != ""):?>
			<img src="images/stories/hotels/<?php echo $row->image?>" />
			<?php endif; ?>
		</div>
		<div>
			<?php echo $row->description;?>
		</div>
		<h2><?php echo JText::_("Hotel_detail");?></h2>
		<table class="hotel-grid">
			<tr>
				<td><?php echo JText::_("ABK_START")?></td>
				<td><?php echo $row->star?></td>
			</tr>
			<tr>
				<td><?php echo JText::_("ABK_LOW_RATE")?></td>
				<td><?php echo $row->min_rate?></td>
			</tr>
			<tr>
				<td><?php echo JText::_("ABK_HIGH_RATE")?></td>
				<td><?php echo $row->max_rate?></td>
			</tr>
			<tr>
				<td><?php echo JText::_("ABK_CHECKIN_TIME")?></td>
				<td><?php echo $row->checkin?></td>
			</tr>
			<tr>
				<td><?php echo JText::_("ABK_CHECKOUT_TIME")?></td>
				<td><?php echo $row->checkout;?></td>
			</tr>
			<tr>
				<td><?php echo JText::_("ABK_NUM_FLOOR")?></td>
				<td><?php echo $row->floor_num;?></td>
			</tr>
			<tr>
				<td><?php echo JText::_("ABK_NUM_RES")?></td>
				<td><?php echo $row->rest_num;?></td>
			</tr>
			<tr>
				<td><?php echo JText::_("ABK_NUM_ROOM")?></td>
				<td><?php echo $row->room_num;?></td>
			</tr>
			<tr>
				<td><?php echo JText::_("ABK_BUILT")?></td>
				<td><?php echo $row->built;?></td>
			</tr>
		</table>
		
		<style>
		table.hotel-grid {width: 100%;}
		
		table.hotel-grid tr td,table.hotel-grid tr th {border:1px solid #ccc;}
		table.hotel-grid tr th {background:#eee;}
		table.hotel-grid tbody tr:hover {background:#eee;}
		</style>
		<?php
	}
}
?>

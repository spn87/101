<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport("joomla.application.component.view");

class HotelViewHotel extends JView
{
	public function display($tpl = null)
	{
        parent::display($tpl);
	}
	
	public function index($hotels)
	{
		?>			
		<table class="adminlist">
			<thead>
				<tr>
					<th>#</th>
					<th>Hotel name</th>
					<th>Province</th>
					<th>Star</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>
			</thead>
		<?php
		$i=0;
		foreach ($hotels as $hotel):
		++$i;
		?>
		<tr class="row<?php echo ($i%2==0 ? "0":"1" )?>">
			<td><?php echo $i;?></td>
			<td><?php echo $hotel->name?></td>
			<td><?php echo $hotel->gname;?></td>
			<td><?php echo $hotel->star;?></td>
			<td><a href="index.php?option=com_hotel&task=add&id=<?php echo $hotel->id?>">Edit</a></td>
			<td><a href="index.php?option=com_hotel&task=delete&id=<?php echo $hotel->id?>">Delete</a></td>
		</tr>
		
		<?php
		endforeach;
		?>
		</table>
		<?php
	}

	public function add($hotelGroup,$data)
	{
		$hotelGroupOpt = "";
		foreach ($hotelGroup as $g)
		{
			$hotelGroupOpt .= "<option value='".$g->id."' ".($g->id == $data["g_id"] ? "selected='selected'":"").">".$g->name."</option>";
		}
		?>
		<form class="adminForm hotel" action="index.php?option=com_hotel&task=save" method="post" enctype="multipart/form-data">
			<table class="adminlist">
				<tr>
					<td>Province</td>
					<td>
						<select name="g_id"><?php echo $hotelGroupOpt;?></select>
					</td>
				</tr>
				<tr>
					<td>Image</td>
					<td><input type="file" name="image" /> <?php echo ($data["image"] != "") ? "<a href='".JURI::base()."../images/stories/hotels/".$data["image"]."'>View</a>":""?></td>
				</tr>
				<tr>
					<td>Hotel Name</td>
					<td><input type="text" value="<?php echo $data["name"];?>" name="name" /></td>
				</tr>
				<tr>
					<td>Minimum rate</td>
					<td><input type="text" value="<?php echo $data["min_rate"];?>" name="min_rate"/></td>
				</tr>
				<tr>
					<td>Maximum rate</td>
					<td><input type="text" value="<?php echo $data["max_rate"];?>" name="max_rate"/></td>
				</tr>
				<tr>
					<td>Start</td>
					<td><input type="text" value="<?php echo $data["star"]?>" name="star" /></td>
				</tr>
				<tr>
					<td>Checkout</td>
					<td><input type="text" value="<?php echo $data["checkout"]?>" name="checkout" /></td>
				</tr>
				<tr>
					<td>Checkin</td>
					<td><input type="text" value="<?php echo $data["checkin"]?>" name="checkin" /></td>
				</tr>
				<tr>
					<td>Number of floors</td>
					<td><input type="text" value="<?php echo $data["floor_num"]?>" name="floor_num" /></td>
				</tr>
				<tr>
					<td>Number of rooms</td>
					<td><input type="text" value="<?php echo $data["room_num"]?>" name="room_num" /></td>
				</tr>
				<tr>
					<td>Number of restaurants</td>
					<td><input type="text" value="<?php echo $data["rest_num"]?>" name="rest_num" /></td>
				</tr>
				<tr>
					<td>Parking service</td>
					<td><input type="text" value="<?php echo $data["parking_service"]?>" name="parking_service" /></td>
				</tr>
				<tr>
					<td>Service 24</td>
					<td><input type="text" value="<?php echo $data["s24"]?>" name="s24" /></td>
				</tr>
				<tr>
					<td>Room voltage</td>
					<td><input type="text" value="<?php echo $data["room_volt"]?>" name="room_volt" /></td>
				</tr>
				<tr>
					<td>Built in year</td>
					<td><input type="text" value="<?php echo $data["built"]?>" name="built" /></td>
				</tr>
				<tr>
					<td colspan="2">Description<br />
					<textarea rows="5" cols="140" name="description"><?php echo $data["description"]?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="Save" /> <input type="button" value="Cancel" onclick="btncancel();" /></td>
				</tr>
			</table>
			<?php if (isset($_GET['id'])):?>
			<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"/>
			<?php endif;?>
		</form>
		<style>
		form.hotel table
		{
			width:100%;
		}
		form.hotel td:first-child
		{
			width: 20% !important;
		}
		</style>
		<script>
		function btncancel()
		{
			window.location = "index.php?option=com_hotel";
		}
		</script>
		<?php
	}
}

?>

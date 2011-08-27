<link rel="stylesheet" type="text/css" media="all" href="jsDatePick_ltr.min.css" />
<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm">

date chechk out &nbsp;:<input type="text" value="" name="datecheckout" id="datecheckout"/><br /><br />
<div id="editcell">
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>			
			<th>
				<?php echo JText::_( 'Tours Title' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'Full Name' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'Address' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'Date of Birth' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'Mail' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'Hotel' ); ?>
			</th>
            <th>
				<?php echo JText::_( 'Departure Date' ); ?>
			</th>
		</tr>
	</thead>
    
	<?php

	$k = 0;

	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	
	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_ttbooking&controller=ttbookinchecking&task=edit&cid[]='. $row->id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->tcode; ?></a>
			</td>
            <td>
				<a href="<?php echo $link; ?>"><?php echo $row->fullname; ?></a>
			</td>
            <td>
				<a href="<?php echo $link; ?>"><?php echo $row->address; ?></a>
			</td><td>
				<a href="<?php echo $link; ?>"><?php echo $row->gender; ?></a>
			</td><td>
				<a href="<?php echo $link; ?>"><?php echo $row->dob; ?></a>
			</td><td>
				<a href="<?php echo $link; ?>"><?php echo $row->mail; ?></a>
			</td>
            <td>
				<a href="<?php echo $link; ?>"><?php echo $row->departuredate; ?></a>
			</td>
            
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>

<input type="hidden" name="option" value="com_ttbooking" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="ttbookingcheckin" />
</form>

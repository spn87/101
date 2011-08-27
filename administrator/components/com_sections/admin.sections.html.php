<?php
/**
* @version		$Id: admin.sections.html.php 18162 2010-07-16 07:00:47Z ian $
* @package		Joomla
* @subpackage	Sections
* @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* @package		Joomla
* @subpackage	Sections
*/
class sections_html
{
	/**
	* Writes a list of the categories for a section
	* @param array An array of category objects
	* @param string The name of the category section
	*/
	function show( &$rows, $scope, $myid, &$page, $option, &$lists )
	{
		$limitstart = JRequest::getVar('limitstart', '0', '', 'int');

		$user =& JFactory::getUser();

		//Ordering allowed ?
		$ordering = ($lists['order'] == 's.ordering');

		JHTML::_('behavior.tooltip');
		?>
		<form action="index.php?option=com_sections&amp;scope=<?php echo $scope; ?>" method="post" name="adminForm">

		<table>
		<tr>
			<td align="left" width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo htmlspecialchars($lists['search']);?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
				<?php
				echo $lists['state'];
				?>
			</td>
		</tr>
		</table>

		<table class="adminlist">
		<thead>
			<tr>
				<th width="10">
					<?php echo JText::_( 'NUM' ); ?>
				</th>
				<th width="10">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows );?>);" />
				</th>
				<th class="title">
					<?php echo JHTML::_('grid.sort',   'Title', 's.title', @$lists['order_Dir'], @$lists['order'] ); ?>
				</th>
				<th width="5%">
					<?php echo JHTML::_('grid.sort',   'Published', 's.published', @$lists['order_Dir'], @$lists['order'] ); ?>
				</th>
				<th width="8%" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'Order', 's.ordering', @$lists['order_Dir'], @$lists['order'] ); ?>
					<?php if ($ordering) echo JHTML::_('grid.order',  $rows ); ?>
				</th>
				<th width="10%">
					<?php echo JHTML::_('grid.sort',   'Access', 'groupname', @$lists['order_Dir'], @$lists['order'] ); ?>
				</th>
				<th width="5%" nowrap="nowrap">
					<?php echo JText::_( 'Num Categories' ); ?>
				</th>
				<th width="5%" nowrap="nowrap">
					<?php echo JText::_( 'Num Active' ); ?>
				</th>
				<th width="5%" nowrap="nowrap">
					<?php echo JText::_( 'Num Trash' ); ?>
				</th>
				<th width="1%" nowrap="nowrap">
					<?php echo JHTML::_('grid.sort',   'ID', 's.id', @$lists['order_Dir'], @$lists['order'] ); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="13">
					<?php echo $page->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php
		$k = 0;
		for ( $i=0, $n=count( $rows ); $i < $n; $i++ ) {
			$row = &$rows[$i];

			$link 		= 'index.php?option=com_sections&scope=content&task=edit&cid[]='. $row->id;

			$access 	= JHTML::_('grid.access',   $row, $i );
			$checked 	= JHTML::_('grid.checkedout',   $row, $i );
			$published 	= JHTML::_('grid.published', $row, $i );
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td align="center">
					<?php echo $page->getRowOffset( $i ); ?>
				</td>
				<td>
					<?php echo $checked; ?>
				</td>
				<td>
					<span class="editlinktip hasTip" title="<?php echo JText::_( 'Title' );?>::<?php echo htmlspecialchars($row->title); ?>">
					<?php
					if (  JTable::isCheckedOut($user->get ('id'), $row->checked_out ) ) {
						echo htmlspecialchars($row->title);
					} else {
						?>
						<a href="<?php echo JRoute::_( $link ); ?>">
							<?php echo htmlspecialchars($row->title); ?></a>
						<?php
					}
					?></span>
				</td>
				<td align="center">
					<?php echo $published;?>
				</td>
				<td class="order">
					<span><?php echo $page->orderUpIcon( $i, true, 'orderup', 'Move Up', $ordering ); ?></span>
					<span><?php echo $page->orderDownIcon( $i, $n, true, 'orderdown', 'Move Down', $ordering ); ?></span>
					<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
					<input type="text" name="order[]" size="5" value="<?php echo $row->ordering; ?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
				</td>
				<td align="center">
					<?php echo $access;?>
				</td>
				<td align="center">
					<?php echo $row->categories; ?>
				</td>
				<td align="center">
					<?php echo $row->active; ?>
				</td>
				<td align="center">
					<?php echo $row->trash; ?>
				</td>
				<td align="center">
					<?php echo $row->id; ?>
				</td>
				<?php
				$k = 1 - $k;
				?>
			</tr>
			<?php
		}
		?>
		</tbody>
		</table>

		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="scope" value="<?php echo $scope;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="chosen" value="" />
		<input type="hidden" name="act" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
		<?php
	}

	/**
	* Writes the edit form for new and existing categories
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.  Note that the <var>section</var> property <b>must</b> be defined
	* even for a new record.
	* @param JTableCategory The category object
	* @param string The html for the image list select list
	* @param string The html for the image position select list
	* @param string The html for the ordering list
	* @param string The html for the groups select list
	*/
	function edit( &$row, $option, &$lists )
	{
		JRequest::setVar( 'hidemainmenu', 1 );

		global $mainframe;

		$editor =& JFactory::getEditor();

		if ( $row->name != '' ) {
			$name = $row->name;
		} else {
			$name = JText::_( 'New Section' );
		}
		if ($row->image == '') {
			$row->image = 'blank.png';
		}

		JFilterOutput::objectHTMLSafe( $row, ENT_QUOTES, 'description' );
		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}

			if ( form.title.value == '' ){
				alert("<?php echo JText::_( 'Section must have a title', true ); ?>");
			} else {
				<?php
				echo $editor->save( 'description' ) ; ?>
				submitform(pressbutton);
			}
		}
		</script>

		<form action="index.php" method="post" name="adminForm">

		<div class="col width-60">
			<fieldset class="adminform">
				<legend><?ph
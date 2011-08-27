<?php
/**
 * @version		$Id: weblink.php 14401 2010-01-26 14:10:00Z louis $
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Weblinks Component Weblink Model
 *
 * @package		Joomla
 * @subpackage	Weblinks
 * @since 1.5
 */
class WeblinksModelWeblink extends JModel
{
	/**
	 * Weblink id
	 *
	 * @var int
	 */
	var $_id = null;

	/**
	 * Weblink data
	 *
	 * @var array
	 */
	var $_data = null;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();

		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	}

	/**
	 * Method to set the weblink identifier
	 *
	 * @access	public
	 * @param	int Weblink identifier
	 */
	function setId($id)
	{
		// Set weblink id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	/**
	 * Method to get a weblink
	 *
	 * @since 1.5
	 */
	function &getData()
	{
		// Load the weblink data
		if ($this->_loadData())
		{
			// Initialize some variables
			$user = &JFactory::getUser();

			// Make sure the weblink is published
			if (!$this->_data->published) {
				JError::raiseError(404, JText::_("Resource Not Found"));
				return false;
			}

			// Check to see if the category is published
			if (!$this->_data->cat_pub) {
				JError::raiseError( 404, JText::_("Resource Not Found") );
				return;
			}

			// Check whether category access level allows access
			if ($this->_data->cat_access > $user->get('aid', 0)) {
				JError::raiseError( 403, JText::_('ALERTNOTAUTH') );
				return;
			}
		}
		else  $this->_initData();

		return $this->_data;
	}

	/**
	 * Method to increment the hit counter for the weblink
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function hit()
	{
		global $mainframe;

		if ($this->_id)
		{
			$weblink = & $this->getTable();
			$weblink->hit($this->_id);
			return true;
		}
		return false;
	}

	/**
	 * Tests if weblink is checked out
	 *
	 * @access	public
	 * @param	int	A user id
	 * @return	boolean	True if checked out
	 * @since	1.5
	 */
	function isCheckedOut( $uid=0 )
	{
		if ($this->_loadData())
		{
			if ($uid) {
				return ($this->_data->checked_out && $this->_data->checked_out != $uid);
			} else {
				return $this->_data->checked_out;
			}
		}
	}

	/**
	 * Method to checkin/unlock the weblink
	 *
	 * @acces
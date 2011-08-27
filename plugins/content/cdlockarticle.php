<?php
/**
 * Core Design Lock Article plugin for Joomla! 1.5
 * @author		Daniel Rataj, <info@greatjoomla.com>
 * @package		Joomla
 * @subpackage	Content
 * @category	Plugin
 * @version		1.0.0
 * @copyright	Copyright (C) 2007 - 2010 Great Joomla!, http://www.greatjoomla.com
 * @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL 3
 * 
 * This file is part of Great Joomla! extension.   
 * This extension is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import library dependencies
jimport('joomla.plugin.plugin');

/**
 * Core Design Lock Article plugin
 *
 * @author		Daniel Rataj <info@greatjoomla.com>
 * @package		Core Design
 * @subpackage	Content
 */
class plgContentCdLockArticle extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object		$subject The object to observe
	 * @since	1.0
	 */
	function plgContentCdLockArticle(&$subject)
	{
		parent::__construct($subject);

		// load plugin parameters
		$this->plugin = &JPluginHelper::getPlugin('content', 'cdlockarticle');
		$this->params = new JParameter($this->plugin->params);

		// load language
		JPlugin::loadLanguage('plg_content_cdlockarticle', JPATH_ADMINISTRATOR);
	}
	
	/**
	 * Joomla! function
	 * 
	 * @return void
	 */
	function onAfterDispatch() {
		$action = JRequest::getString('cdlockarticleaction', '', 'POST'); // action
		
		// prevent empty action
		if (!$action) return false;
				
		switch($action) {
			case 'lockArticle':
				$this->lockArticle();
				break;
			case 'unlockArticle':
				$this->unlockArticle();
				break;
			case 'checkPassword':
				$this->checkPassword();
				break;
			default:
				return false;
				break;
		}
		
	}
	
	/**
	 * Joomla! onPrepareContent() function
	 * 
	 * @return string		Article output.
	 */
	function onPrepareContent(&$article, &$params, $limitstart=0)
	{
		$document = &JFactory::getDocument(); // set document for next usage
		
		// prevent script loading in PDF or RSS output
		if ($document->getType() != 'html') return true;
		
		// disable category and section view
		if (JRequest::getCmd('view', '') == 'section' or JRequest::getCmd('view', '') == 'category') {
			$layout = JRequest::getCmd('layout');
			if ($layout == 'blog') return true;
		}
		
		// set article id to context variable
		$this->params->set('articleid', $article->id);
		
		// check if db table exists
		$this->checkDatabase();
		
		// Scriptegrator check
		if (!class_exists('JScriptegrator')) {
			JError::raiseNotice('', JText::_('CDLOCKARTICLE_ENABLE_SCRIPTEGRATOR'));
			return false;
		} else {
			$message = JScriptegrator::check('1.3.8', 'jquery', 'site');
			if ($message)  {
			   JError::raiseNotice('', $message);
			   return false;
      		}
		}
		
		
		// user is authorized to lock article
		if ($this->accessToLock($article->created_by)) {
			$article->text = $this->lockArticleTemplate() . $article->text;
		} else {
			// article is authorized already
			if ($this->isAuth()) return true;
			
			// check if there is a password for article
			if (!$this->dbValue('id')) return true;
			
			// replace $article->text variable with password form
			$article->text = $this->passform();
		}
		
		// once repeat script
		static $once = 0;
		if (!$once) {
			
			$live_path = JURI::root(true) . '/'; // define live site
			
			$theme = $this->params->get('theme', 'ui-lightness');
			JScriptegrator::importUITheme($theme, 'ui.tabs');
			
			$document->addScript($live_path . 'plugins/content/cdlockarticle/utils/js/jquery.cdlockarticle.js');
			
			$js = "
			<!--
			jQuery(document).ready(function($){
				if ($.cdlockarticle) {
					$.extend( $.cdlockarticle, {
						settings: {
							theme : '$theme',
							isAdmin: " . ($this->isAdmin() ? '1' : '0') . "
	    				},
	    				language: {
							CDLOCKARTICLE_PASSWORD : '" . JText::_('CDLOCKARTICLE_PASSWORD') . "',
							CDLOCKARTICLE_PASSWORD2 : '" . JText::_('CDLOCKARTICLE_PASSWORD2') . "',
							CDLOCKARTICLE_PASSWORD_DO_NOT_MATCH : '" . JText::_('CDLOCKARTICLE_PASSWORD_DO_NOT_MATCH') . "',
							CDLOCKARTICLE_HEADER : '" . JText::_('CDLOCKARTICLE_HEADER') . "',
							CDLOCKARTICLE_PASSWORD_TO_UNLOCK : '" . JText::_('CDLOCKARTICLE_PASSWORD_TO_UNLOCK') . "'
	    				}
	    			});
	    			$.cdlockarticle.initiator();
				}
			});
			// -->";
			$document->addStyleSheet($live_path . 'plugins/content/cdlockarticle/css/cdlockarticle.css');
			$document->addScriptDeclaration($js);
			
			$once = 1;
		}
		
		// return script
		return $article->text;

	}
	
	/**
	 * Check password routine
	 * 
	 * @return void
	 */
	function checkPassword() {
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$article_password = $this->dbValue('password');
		
		$password = JRequest::getString('articlepassword', '', 'POST'); // password or action
		
		// check and set password if allowed
		if ($article_password == md5($password)) {
			$this->setAuthArticle();
			jexit();
		} else {
			jexit(JText::_('CDLOCKARTICLE_WRONG_PASSWORD'));
		}
	}
	
	/**
	 * Lock Article
	 *  
	 * @return void
	 */
	function lockArticle() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$password = md5(JRequest::getString('password', '', 'POST'));
		
		$headertext = JRequest::getString('headertext', '', 'POST');
		
		$articleid = $this->params->get('articleid');
		
		$user =& JFactory::getUser();
		$userid = $user->id;
		
		$db =& JFactory::getDBO();
		
		$query = 'INSERT INTO `#__cdlockarticle` (`id`, `articleid`, `password`, `headertext`, `lockedby`) VALUES (' .
		'0, '.
		'' . $articleid . ', '.
		'' . $db->Quote($db->getEscaped($password)) . ', '.
		'' . $db->Quote($db->getEscaped($headertext)) . ', '.		
		'' . $userid . ');';

		$db->setQuery($query);
		if ($db->query()) {
			$this->close();
		} else {
			$this->close(JText::_('CDLOCKARTICLE_DB_ERROR'));
		}
	}
	
	/**
	 * Unlock Article
	 * 
	 * @return void
	 */
	function unlockArticle() {
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		
		$articleid = $this->params->get('articleid');
		
		// check password
		$article_password = $this->dbValue('password');
		$password = JRequest::getString('password', '', 'POST'); // password or action
		
		if ($this->isAdmin() or $article_password == md5($password)) {
			// password correct
			
			$user =& JFactory::getUser();
			$userid = $user->id;
			
			$db =& JFactory::getDBO();
			
			$query = 'DELETE FROM `#__cdlockarticle` WHERE `articleid` = ' . $articleid . '';
	
			$db->setQuery($query);
			if ($db->query()) {
				$this->close();
			} else {
				$this->close(JText::_('CDLOCKARTICLE_DB_ERROR'));
			}
		} else {
			// password incorrect
			jexit(JText::_('CDLOCKARTICLE_WRONG_PASSWORD'));
		}
	}
	
	/**
	 * Lock access
	 * 
	 * Define if user is authorized to lock article. 
	 * 
	 * @return boolean		True, if user is authorized.
	 */
	function accessToLock($created_by = 0) {
		$user =& JFactory::getUser();
		
		// user is guest only
		if ($user->guest) return false;
		
		// Create a user access object for the user
		$access					= new stdClass();
		$access->canEdit		= $user->authorize('com_content', 'edit', 'content', 'all');
		$access->canEditOwn		= $user->authorize('com_content', 'edit', 'content', 'own');
		$access->canPublish		= $user->authorize('com_content', 'publish', 'content', 'all');
		
		// user is not authorized to edit articles
		if (!($access->canEdit || $access->canEditOwn)) return false;
		if ($user->gid <= 19 && $created_by != $user->id) return false;
		
		return true;
	}
	
	/**
	 * Check if article is authorized
	 * 
	 * @return boolean		True, if article is authorized.
	 */
	function isAuth() {
		$session = &JFactory::getSession();
		
		$sessionname = 'cdLockArticle';
		
		$articleid = $this->params->get('articleid');
		
		$allowed = $session->get($sessionname, array());
		
		// prevent already existing article id in session
		if (in_array($articleid, $allowed)) return true;
		
		return false;
	}
	
	/**
	 * Set authorized article to session
	 * 
	 * @return void
	 */
	function setAuthArticle() {
		$session = &JFactory::getSession();
		
		$sessionname = 'cdLockArticle';
		
		$articleid = $this->params->get('articleid');

		$allowed = $session->get($sessionname, array());
		
		// prevent already existing article id in session
		if (in_array($articleid, $allowed)) return false;
		
		array_push($allowed, $articleid);
		
		$session->set($sessionname, $allowed);
		
	}
	
	/**
	 * Lock article template
	 * 
	 * @return string		Lock article template.
	 */
	function lockArticleTemplate() {
		$tmpl = '';
		
		$uri = JRoute::_($this->getURI());
		
		$tmpl .= '<div class="lockarticle ' . $this->params->get('theme', 'ui-lightness') . '">';
			
			$locked = ($this->dbValue('id') ? 1 : 0);
			
			// article is not locked
			$locked_button = '<button type="button" title="' . JText::_('CDLOCKARTICLE_UN_LOCK_ARTICLE') . '"><span class="ui-icon ui-icon-locked">&nbsp;</span></button>';
			// article is locked already
			if ($locked) $locked_button = '<button type="button" title="' . JText::_('CDLOCKARTICLE_UN_LOCK_ARTICLE') . '"><span class="ui-icon ui-icon-unlocked">&nbsp;</span></button>';
			$tmpl .= $locked_button;
				$tmpl .= '<form action="' . $uri . '" method="post" name="lockArticle">';
					$tmpl .= '<input type="hidden" name="cdlockarticleaction" value="' . ($locked ? 'unlockArticle' : 'lockArticle') . '" />';
					$tmpl .= '<input type="hidden" name="password" value="" />';
					$tmpl .= '<input type="hidden" name="headertext" value="" />';
					$tmpl .= JHTML::_('form.token');
				$tmpl .= '</form>';
			$tmpl .= '</div>';
		$tmpl .= '</div>';
		
		
		return $tmpl;
	}
	
	/**
	 * Insert password form
	 * 
	 * @return string		Form.
	 */
	function passform() {
		
		$uri = $this->getURI();
		
		$aid = $this->params->get('articleid');
		
		$headertext = stripslashes($this->dbValue('headertext'));
		
		$tmpl = '<div class="lockarticle_box ' . $this->params->get('theme', 'ui-lightness') . '">';
			$tmpl .= '<div class="ui-tabs ui-widget ui-widget-content ui-corner-all">';
				$tmpl .= '<div class="ui-tabs-panel ui-widget-content ui-corner-bottom">';
				
					$tmpl .= '<form action="' . $uri . '" method="post" name="checkarticlepassword">';
						if (!$headertext) {
							$headertext = JText::_('CDLOCKARTICLE_ENTERPASSWORD');
						}
						$tmpl .= '<div class="headertext">' . $headertext . '</div>';
						$tmpl .= '<div class="spacer"></div>';
						$tmpl .= '<input type="text" maxlength="255" name="articlepassword" title="' . JText::_('CDLOCKARTICLE_ENTERPASSWORD') . '" />';
						$tmpl .= '<input type="hidden" name="cdlockarticleaction" value="checkPassword" />';
						$tmpl .= '<div class="clr"></div>';
						$tmpl .= JHTML::_('form.token');
					$tmpl .= '</form>';
					
				$tmpl .= '</div>';
			$tmpl .= '</div>';
		$tmpl .= '</div>';
		
		return $tmpl;
	}
	
	/**
	 * Get URI wrapper
	 * 
	 * @return string		URI.
	 */
	function getURI() {
		jimport('joomla.enviroment.request');
		$uri = JRequest::getURI();
		return str_replace( '&', '&amp;', $uri );
	}
	
	/**
	 * Get DB value
	 * 
	 * @param $value
	 * @return string		Database value.
	 */
	function dbValue($value = 'id') {
		$db = &JFactory::getDBO();
		
		$aid = $this->params->get('articleid');
		
		$query = 'SELECT `' . $value . '` FROM `#__cdlockarticle` WHERE `articleid` = ' . $aid . '';

		$db->setQuery($query);
		$result = $db->loadResult();
		
		if ($result) return $result;
		return '';
	}

	/**
	 * Method to determine a hash for anti-spoofing variable names
	 *
	 * @return	string	Hashed var name
	 */
	function getToken() {
		jimport('joomla.utilities.utility');
		$token = JUtility::getToken();
		return $token;
	}

	/**
	 * Check database
	 *
	 * Check if database exists, if no, create one
	 *
	 * @return void
	 */
	function checkDatabase() {
		$db = &JFactory::getDBO();

		$query = '
	  CREATE TABLE IF NOT EXISTS `#__cdlockarticle` (' .
            '`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,' .
        	'`articleid` INT(11) UNSIGNED NOT NULL,' .
        	'`password` VARCHAR(255) DEFAULT \'\',' .
			'`headertext` MEDIUMTEXT DEFAULT \'\',' .
			'`lockedby` INT(11) UNSIGNED NOT NULL,'. 
			' PRIMARY KEY (`id`)' .
            ') TYPE=MyISAM;';

		$db->setQuery($query);

		if (!$db->query())
		{
			JError::raiseError(500, $db->stderr());
		}
	}

	/**
	 * Global close wrapper
	 *
	 * @param $msg		message to display
	 *
	 * @return void
	 */
	function close($msg = '') {
		global $mainframe;
		$mainframe->close($msg);
	}
	
	/**
	 * Global redirect wrapper
	 * 
	 * @param $url
	 * @param $msg
	 * @return void
	 */
	function redirect($url = 'index.php', $msg = '') {
		global $mainframe;
		$mainframe->redirect($url, $msg);
	}
	
	/**
	 * Check if user has admin or super admin privileges
	 * 
	 * @return boolean
	 */
	function isAdmin() {
		$user =& JFactory::getUser();
		
		// user is guest only
		if ($user->guest) return false;
		
		// get usertype
		$usertype = strtolower($user->usertype);
		
		if ($usertype == 'super administrator' || $usertype == 'administrator') {
			return true;
		}
		
		return false;
		
	}

}
?>
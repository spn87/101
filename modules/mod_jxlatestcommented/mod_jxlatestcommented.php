<?php
/**
 * Jx Latest Commented - Show latest commented items from content, weblinks, Mamblog or Jx Directory.
 *
 * @package jx_modules
 * @subpackage Jx Latest Commented
 * @version $Id$
 * @copyright (C) 2006-2010 Olle Johansson. All rights reserved
 * @license Released under GNU/GPL License v2 : http://www.gnu.org/licenses/gpl-2.0.html
 **/

/*  Copyright 2010

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2
    as published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/*
TODO:

* Add sort order support to allow admin to select whether to sort by date or most commented.
* Add missing config params, test thoroughly, add css file

CHANGES
2005-10-23 - Fixed problem with selection of content with latest comment.
2005-10-24 - Added support for MosCom.
2005-10-26 - Added contentsection parameter.
2005-11-22 - Fixed link to Joomla content items.
2006-10-11 - Added support for !JoomlaComment v2.40
2006-11-02 - Added support for Jom Comment (sent in by Gary Meleski), Gabrovo and OpenComment. A couple of bug fixes.
2006-11-03 - Refactored the comment system code a bit.
2006-11-11 - Added native support for Joomla 1.5 and Itemid to links.
2006-11-18 - Added parameter to exclude sections to show comments from.
2006-11-25 - Added support for jComments (sent in by smart).
2008-10-01 - Added support for Jambook (sent in by Bo Hansen).
2010-10-10 - Refactored into proper Joomla 1.5 MVC support.
*/

defined( '_JEXEC' ) or die('Restricted access.');

// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

try {
    // Run the helper to generate the file list.
    $jxlc = new modJxLatestCommentedHelper($params);
    $comments = $jxlc->getCommentList();
    $p = $jxlc->getParsedParams();

    // Load the view to render the html for the file list.
    $document =& JFactory::getDocument();
    $document->addStyleSheet(JURI::base() . "modules/mod_jxlatestcommented/mod_latestcommented.css");
    require( JModuleHelper::getLayoutPath( 'mod_jxlatestcommented' ) );
} catch (Exception $e) {
    echo JText::_("Error:") . ' ' . $e->getMessage();
}


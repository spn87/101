<?php
/**
 * Helper class for the Jx Latest Commented module.
 *
 * @package jx_modules
 * @subpackage jxlatestcommented
 * @version $Id$
 * @author Olle Johansson <Olle@Johansson.com>
 * @copyright (C) 2006-2010 Olle Johansson. All rights reserved
 * @license Released under GNU/GPL License v2 : http://www.gnu.org/licenses/gpl-2.0.html
 */

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

defined( '_JEXEC' ) or die('Restricted access.');

require_once( JPATH_SITE . DS . 'components' . DS . 'com_content' . DS . 'helpers' . DS . 'route.php' );
jimport('joomla.utilities.date');

class modJxLatestCommentedHelper
{
    protected $_p;

    /**
     * Create a new helper object based on module parameters.
     * @param Object Module parameter object.
     */
    public function __construct( &$params )
    {
        $this->_p = $this->readParams( $params );
    }

    /**
     * Set default values for all possible module parameters.
     * @params Object Parameter object for this module.
     * @return JObject Parsed parameters.
     */
    public function readParams( &$params )
    {
        $p = new JObject();
        $p->count = (int) $params->get( 'count', 5 );
        $p->showcomments = $params->get( 'showcomments', 0 );
        $p->showdate = $params->get( 'showdate', '0' );
        $p->showcomment = $params->get( 'showcomment', 0 );
        $p->commentlength = (int) $params->get( 'commentlength', 0 );
        $p->contenttype = $params->get( 'contenttype', 'content' );
        $p->contentsection = (int) $params->get( 'contentsection', 0 );
        $p->excludesection = (int) $params->get( 'excludesection', 0 );
        $p->orderby = $params->get( 'orderby', 'commentdate' );
        $p->sortdir = $params->get( 'sortdir', 'DESC' );
        $p->commentsystem = $params->get( 'commentsystem', 'akocomment' );
        $p->preitem = $params->get( 'preitem', '' );
        $p->postitem = $params->get( 'postitem', '' );
        $p->pretext = $params->get( 'pretext', '' );
        $p->posttext = $params->get( 'posttext', '' );
        $p->lang_comments = $params->get( 'lang_comments', JText::_('comments') );
        $p->linktarget = $params->get( 'linktarget', '' );
        $p->linktarget = $p->linktarget ? " target='$p->linktarget'" : "";
        $p->dateformat = $params->get( 'dateformat', JText::_('DATE_FORMAT_LC1') );
        $p->cls_div = $params->get( 'cls_div', '' );
        $p->cls_list = $params->get( 'cls_list', '' );
        $p->cls_listitem = $params->get( 'cls_listitem', '' );
        $p->cls_link = $params->get( 'cls_link', '' );
        $p->cls_commentcount = $params->get( 'cls_commentcount', '' );
        $p->cls_date = $params->get( 'cls_date', '' );
        $p->cls_comment = $params->get( 'cls_comment', '' );
        $p->cls_nocomments = $params->get( 'cls_nocomments', '' );
        return $p;
    }

    /**
     * Returns the parsed params object.
     * @return JObject Parsed parameters.
     */
    public function getParsedParams()
    {
        return $this->_p;
    }

    /**
     * Returns a list of commented items based on configured content component and comment system.
     * @return Array List of commented items.
     */
    public function getCommentList()
    {
        $comp =& $this->getContentComponent( $this->_p->contenttype );
        $commentsystem = !empty($comp->commentsystem) ? $comp->commentsystem : $this->_p->commentsystem;
        $comp =& $this->addCommentSelections( $commentsystem, $comp );
        return $this->readContentList( $comp );
    }

    /**
     * Get content component query values for given content section.
     * @param String Content component type
     * @return JObject Content component configuration object.
     */
    public function getContentComponent( $contenttype="content" )
    {
        $db =& JFactory::getDBO();

        // Default value for variables.
        $comp = new JObject();
        $comp->contenttype = $contenttype;
        $comp->where = array();
        $comp->where[] = "1=1";
        $comp->commentsystemfound = true;

        // Define sort order.
        $comp->orderby = "commentdate";
        if ($this->_p->orderby && in_array($this->_p->orderby, array('commentdate', 'contentdate', 'commentcount'))) {
            $comp->orderby = $this->_p->orderby;
        }
        if ($this->_p->sortdir && in_array($this->_p->sortdir, array('ASC', 'DESC'))) {
            $comp->orderby .= " " . $this->_p->sortdir;
        } else {
            $comp->orderby .= " DESC";
        }

        $comp->datefields = ", MAX(cc.date) AS commentdate";
        $comp->contentidfield = "contentid";

        // Set some variables for the SQL query based on the content type chosen.
        $now = new JDate();
        switch ( $contenttype ) {
            case "mamblog":
                $comp->table = "content";
                $comp->fields = "c.id AS id, c.title AS title, COUNT(cc.id) AS comments";
                $comp->fields .= ", CASE WHEN c.publish_up = '" . $db->getNullDate() . "' THEN c.created ELSE c.publish_up END AS contentdate";
                $comp->groupby = "c.id";
                $comp->where[] = "c.state = 1";
                $comp->where[] = "(c.publish_up = '" . $db->getNullDate() . "' OR c.publish_up < '{$now->toMySQL()}')";
                if ( $this->_p->contentsection ) {
                    $comp->where[] = "c.sectionid = " . $this->_p->contentsection;
                }
                if ( $this->_p->excludesection ) {
                    $comp->where[] = "c.sectionid <> " . $this->_p->excludesection;
                }
                $comp->linkurl = "index.php?option=com_mamblog&task=show&action=view&id=";
                $comp->type = "content";
                break;
            case "mxdirectory":
                $comp->table = "mxdirectory";
                $comp->fields = "c.id AS id, c.title AS title, COUNT(cc.id) AS commentcount";
                $comp->fields .= ", c.created AS contentdate";
                $comp->groupby = "c.id";
                $comp->where[] = "c.state=1";
                $comp->linkurl = "index.php?option=com_mxdirectory&task=view&id=";
                break;
            case "weblinks":
                $comp->table = "weblinks";
                $comp->fields = "c.id AS id, c.title AS title, COUNT(cc.id) AS commentcount";
                $comp->fields .= ", c.date AS contentdate";
                $comp->groupby = "c.id";
                $comp->where[] = "c.published=1";
                $comp->linkurl = "index.php?option=com_weblinks&task=view&id=";
                break;
            case "jambook":
                $comp->table = "jx_jambook";
                $comp->fields = "c.id AS id, c.title AS title, COUNT(cc.id) AS commentcount";
                $comp->fields .= ", CASE WHEN c.publish_up = '" . $db->getNullDate() . "' THEN c.created ELSE c.publish_up END AS contentdate";
                $comp->groupby = "c.id";
                $comp->linkurl = "index.php?option=com_jambook&task=view&id=";
                $comp->commentsystem = "jambook";
                break;
            case "content":
            default:
                $comp->contenttype = 'content';
                $comp->table = "content";
                $comp->fields = "c.id AS id, c.title AS title, COUNT(cc.id) AS commentcount";
                #$comp->fields .= ", CASE WHEN CHAR_LENGTH(cc.alias) THEN CONCAT_WS(':', cc.id, cc.alias) ELSE cc.id END AS catslug";
                $comp->fields .= ", CASE WHEN c.publish_up = '" . $db->getNullDate() . "' THEN c.created ELSE c.publish_up END AS contentdate";
                $comp->fields .= ", c.catid AS catslug";
                $comp->fields .= ", CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(':', c.id, c.alias) ELSE c.id END as slug";
                $comp->groupby = "c.id";
                $comp->where[] = "c.state=1";
                $comp->where[] = "(c.publish_up = '" . $db->getNullDate() . "' OR c.publish_up < '{$now->toMySQL()}')";
                if ( $this->_p->contentsection) {
                    $comp->where[] = "c.sectionid = " . $this->_p->contentsection;
                }
                if ( $this->_p->excludesection ) {
                    $comp->where[] = "c.sectionid <> " . $this->_p->excludesection;
                }
                $comp->linkurl = "index.php?option=com_content&task=view&id=";
                $comp->type = "content";
        }
        return $comp;
    }

    /**
     * Add comment system selection query values to component configuration object.
     * @param String Comment system to add values for.
     * @param JObject Component object configuration
     * @return JObject Modified component object configuration
     */
    public function addCommentSelections( $commentsystem, &$comp )
    {
        // Set some variables for the SQL query based on the comment system chosen.
        switch ( $commentsystem ) {
            case "mxcomment":
                $comp->commenttable = "mxcomment";
                $comp->where[] = "component='$this->_p->contenttype'";
                $comp->where[] = "cc.published=1";
                break;
            case "combo":
                $comp->commenttable = "combomax";
                $comp->where[] = "cc.state=1";
                break;
            case "moscom":
                $comp->commenttable = "content_comments";
                $comp->contentidfield = "articleid";
                $comp->where[] = "cc.published=1";
                $comp->orderby = "ccid DESC";
                $comp->datefields = ", MAX(cc.date) AS commentdate, MAX(cc.id) AS ccid";
                break;
            case "akocomment":
                $comp->commenttable = "akocomment";
                $comp->where[] = "cc.published=1";
                break;
            case "joomlacomment":
                $comp->commenttable = "comment";
                $comp->where[] = "cc.published=1";
                break;
            case "jomcomment":
                $comp->commenttable = "jomcomment";
                $comp->where[] = "cc.published=1";
                break;
            case "opencomment":
                $comp->commenttable = "opencomment";
                $comp->where[] = "cc.published=1";
                break;
            case "gabrovo":
                $comp->commenttable = "gabrovo";
                $comp->where[] = "cc.published=1";
                break;
            case "jcomments":
                $comp->commenttable = "jcomments";
                $comp->contentidfield = "object_id";
                #$comp->fields .= ", cc.comment AS comment";
                $comp->fields .= ", (SELECT comment FROM jos_jcomments WHERE id=MAX(cc.id)) AS comment";
                $comp->datefields = ", MAX(cc.date) AS commentdate";
                $comp->where[] = "cc.published=1";
                $comp->where[] = "cc.object_group='com_{$comp->contenttype}'";
                break;
            case "jambook":
                $comp->commenttable = "jx_jambook";
                $comp->contentidfield = "id";
                $comp->datefields = ", MAX(cc.created) AS commentdate";
                $comp->where[] = "cc.state=1";
                break;
            default:
                throw new Exception("Couldn't find configured comment system: " . $commentsystem);
        }
        return $comp;
    }

    /**
     * Create the SQL query and return a list of items
     * @param Object Content component definition
     * @return Array List of content items latest commented upon.
     */
    private function readContentList( $comp )
    {

        if ( empty($comp->orderby) || empty($comp->fields) ) {
            throw new Exception("Couldn't create query.");
        }

        // Build query
        $query = "SELECT $comp->fields $comp->datefields"
                . "\nFROM #__$comp->table AS c"
                . "\nLEFT JOIN #__$comp->commenttable AS cc ON c.id = cc.$comp->contentidfield"
                . "\nWHERE (" . ( implode( ' AND ', $comp->where ) ) . ")"
                . "\nGROUP BY $comp->groupby"
                . "\nORDER BY $comp->orderby LIMIT " . $this->_p->count;

        $db =& JFactory::getDBO();
        $db->setQuery( $query );
        #print $db->getQuery();

        // Retrieve the list of returned records as an array of objects.
        $rows = $db->loadObjectList();

        // Make sure there was no database error.
        if ($db->getErrorMsg()) {
            throw new Exception("Error loading comments: " . $db->getErrorMsg());
        }

        // Loop through result list and fix some of the data for display.
        if (empty($rows)) return array();
        foreach( $rows as $row ) {
            $commentdate = new JDate( $row->commentdate );
            $row->commentdate = $commentdate->toFormat( $this->_p->dateformat );
            $contentdate = new JDate( $row->contentdate );
            $row->contentdate = $contentdate->toFormat( $this->_p->dateformat );
            if ($this->_p->commentlength && mb_strlen($row->comment) > $this->_p->commentlength) {
                $row->comment = mb_substr($row->comment, 0, $this->_p->commentlength) . "...";
            }
            if ($comp->type == 'content') {
                $row->itemlink = JRoute::_( ContentHelperRoute::getArticleRoute( $row->slug, $row->catslug, $this->_p->contentsection ) );
            } else {
                $row->itemlink = JRoute::_( $comp->linkurl . $row->id );
            }
        }

        return $rows;
    }

}


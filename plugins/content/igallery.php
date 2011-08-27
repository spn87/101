<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$mainframe->registerEvent('onPrepareContent', 'displayIgallery');

function displayIgallery(&$row, &$params)
{
    $lang =& JFactory::getLanguage();
    $lang->load('com_igallery', JPATH_ADMINISTRATOR);

    $view = JRequest::getCmd('view',null);
	$id = JRequest::getInt('id',null);
	$layout= JRequest::getCmd('layout',null);

	JRequest::setVar('view', 'igcategory');
	JRequest::setVar('layout', 'default');

	preg_match_all('#\{igallery(.*?)\}#ism',$row->text, $matches);

	foreach( $matches[1] as $pluginParams )
	{
	    (preg_match('#.*?\sid="([0-9]+)".*?#is', $pluginParams, $uid))
	       ?   JRequest::setVar('ig_plg_id',$uid[1])
	       :   JError::raise(2, 400, 'required id');

	    (preg_match('#.*?\scid="([0-9]+)".*?#is', $pluginParams, $cid))
	       ?   JRequest::setVar('ig_plg_category_id',$cid[1])
	       :   JError::raise(2, 400, 'required category');

	    (preg_match('#.*?\spid="([0-9]+)".*?#is', $pluginParams, $pid))
	       ?   JRequest::setVar('ig_plg_profile_id',$pid[1])
	       :   JError::raise(2, 400, 'required profile');

	    (preg_match('#.*?\stype="([a-z]+)".*?#is', $pluginParams, $type))
	       ?   JRequest::setVar('ig_plg_type',$type[1])
	       :   JError::raise(2, 400, 'required type');

	    (preg_match('#.*?\schildren="([0-9]+)".*?#is', $pluginParams, $children))
	       ?   JRequest::setVar('ig_plg_children',$children[1])
	       :   false;
	       
	    (preg_match('#.*?\sshowmenu="([0-9]+)".*?#is', $pluginParams, $showmenu))
	       ?   JRequest::setVar('ig_plg_showmenu',$showmenu[1])
	       :   false;

	    (preg_match('#.*?\stags="([a-zA-Z,]+)".*?#is', $pluginParams, $tags))
	       ?   JRequest::setVar('ig_plg_tag',$tags[1])
	       :   false;

	    (preg_match('#.*?\slimit="([0-9]+)".*?#is', $pluginParams, $limit))
	       ?   JRequest::setVar('ig_plg_photo_limit',$limit[1])
	       :   false;

		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_igallery'.DS.'defines.php');
        require_once(IG_COMPONENT.'controllers'.DS.'igcategory.php');

        $config = array();
        $config['source'] = 'plugin';
        $controller = new igcategoryController($config);

		ob_start();
		$controller->execute('display');
		$pluginHtml = ob_get_contents();
		ob_end_clean();

		$row->text = str_replace('{igallery'.$pluginParams.'}', $pluginHtml, $row->text);
	}

	if($view != null)
	{
		JRequest::setVar('view', $view);
	}

	if($layout != null)
	{
		JRequest::setVar('layout', $layout);
	}

	if($id != null)
	{
		JRequest::setVar('id', $id);
	}

	return true;
}
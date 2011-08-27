	<?php
/**
* Fade Javascript Image Gallery Joomla! 1.5 Native Component
* @version 1.3.3
* @author DesignCompassCorp <admin@designcompasscorp.com>
* @link http://www.designcompasscorp.com
* @license GNU/GPL **/
defined('_JEXEC') or die('Restricted access');


$mainframe->registerEvent('onPrepareContent', 'plgContentFadeGallery');


function plgContentFadeGallery(&$row, &$params, $page=0)
{
	if (is_object($row)) {
		$count=0;
		$count+=plgFadeGallery($row->text, $params);
		$count+=plgFadeGalleryID($row->text, $params);
		return (bool)$count;
	}
	
	$count+=plgFadeGallery($row, $params);
	$count+=plgFadeGalleryID($row, $params);
	
	return (bool)$count;
}

///////////////////
function plgFadeGallery(&$text, &$params)
{
	$options=array();
	$fList=getListToReplace('fadegallery',$options,$text);
	
	for($i=0; $i<count($fList);$i++)
	{
		$replaceWith=getFadeGallery($options[$i],$i);
		$text=str_replace($fList[$i],$replaceWith,$text);	
	}
	
	
	return count($fList);
}



function plgFadeGalleryID(&$text, &$params)
{
	
	$options=array();
	$fList=getListToReplace('fadegalleryid',$options,$text);
	
	for($i=0; $i<count($fList);$i++)
	{
		$replaceWith=getFadeGalleryByID($options[$i],$i);
		$text=str_replace($fList[$i],$replaceWith,$text);	
	}
	
	return count($fList);
}



function getFadeGalleryByID($galleryparams,$count)
{
	require_once(JPATH_SITE.DS.'components'.DS.'com_fadegallery'.DS.'includes'.DS.'fadegalleryclass.php');
	$result='';
	
	$fg=new FadeGalleryClass;
	$galleryrow=$fg->getGallery((int)$galleryparams);
	
	if($galleryrow->folder!='')
	{
		
		$fg_images=$fg->getFileList($galleryrow->folder, $galleryrow->filelist);
		if(count($fg_images)==0)
			return $result;
		
		
	
		$fg_interval=(int)$galleryrow->interval;
		$fg_fadetime=(int)$galleryrow->fadetime;
		$fg_fadestep=(int)$galleryrow->fadestep;
		
		$width=(int)$galleryrow->width;
		$height=(int)$galleryrow->height;
		
		
		
		

		if($width<1)			$width=400;

		if($height<1)			$height=200;

		if($fg_interval==0)		$fg_interval=6000;
		if($fg_interval<1000)	$fg_interval=1000;
	
		if($fg_fadetime==0)		$fg_fadetime=2000;
		if($fg_fadetime<100)	$fg_fadetime=100;
		
		if($fg_fadestep==0)		$fg_fadestep=20;
		if($fg_fadestep<1)		$fg_fadestep=1;
		
		
		$fgpadding=(int)$galleryrow->padding;
		
	
	
		$objectname='fadegalleryid_'.$count;
	
		$result.=$fg->getDiv($fg_images,$width, $height,$objectname,$galleryrow->align,$fgpadding,$galleryrow->cssstyle,'');
		
		JHTML::script('fadegallery.js');
	
		$result.=$fg->getJavaScript($fg_images, $objectname,$fg_interval,$fg_fadetime,$fg_fadestep,$galleryrow->width,$galleryrow->height);
		
	}
	return $result;
	
}

function getFadeGallery($galleryparams,$count)
{
	require_once(JPATH_SITE.DS.'components'.DS.'com_fadegallery'.DS.'includes'.DS.'fadegalleryclass.php');


	$opt=explode(',',$galleryparams);
	if(count($opt)<1)
		return '';
	
	// 1 - Folder
	// 2 - Interval
	
	$folder=$opt[0];
	
	$width=400;			if(count($opt)>1)	$width=(int)$opt[1];
	$height=200;		if(count($opt)>2)	$height=(int)$opt[2];
	$fg_interval=6000;	if(count($opt)>3)	$fg_interval=(int)$opt[3];
	$fg_fadetime=2000;	if(count($opt)>4)	$fg_fadetime=(int)$opt[4];
	$fg_fadestep=20;	if(count($opt)>5)	$fg_fadestep=(int)$opt[5];
	$filelist='';		if(count($opt)>6)	$filelist=$opt[6];
	
	$fgalign='';		if(count($opt)>7)	$fgalign=$opt[7];
	$fgpadding=0;		if(count($opt)>8)	$fgpadding=(int)$opt[8];
	
	$divName='fadegalleryplg_'.$count;

	$fg=new FadeGalleryClass;
	
	$fg_images=$fg->getFileList($folder, $filelist);
	
	if(count($fg_images)<1)
		return '';
	

	$result=$fg->getDiv($fg_images,$width, $height,$divName,$fgalign,$fgpadding,'','');
	JHTML::script('fadegallery.js');
	
	$result.=$fg->getJavaScript($fg_images, $divName,$fg_interval,$fg_fadetime,$fg_fadestep,$width,$height);
	
	return $result;
}



function getListToReplace($par,&$options,&$text)
	{
		$fList=array();
		$l=strlen($par)+2;
	
		$offset=0;
		do{
			if($offset>=strlen($text))
				break;
		
			$ps=strpos($text, '{'.$par.'=', $offset);
			if($ps===false)
				break;
		
		
			if($ps+$l>=strlen($text))
				break;
		
		$pe=strpos($text, '}', $ps+$l);
				
		if($pe===false)
			break;
		
		$notestr=substr($text,$ps,$pe-$ps+1);

			$options[]=substr($text,$ps+$l,$pe-$ps-$l);
			$fList[]=$notestr;
			

		$offset=$ps+$l;
		
			
		}while(!($pe===false));
		
		return $fList;
	}
?>
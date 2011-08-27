<?php
/*
 * ARI Image Slider
 *
 * @package		ARI Image Slider
 * @version		1.0.0
 * @author		ARI Soft
 * @copyright	Copyright (c) 2010 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

defined('ARI_FRAMEWORK_LOADED') or die('Direct Access to this location is not allowed.');

jimport('joomla.filter.filterinput');
jimport('joomla.filesystem.file');

AriKernel::import('Utils.Utils');
AriKernel::import('Utils.AppUtils');
AriKernel::import('Web.JSON.JSONHelper');
AriKernel::import('FileSystem.Folder');

class AriImageSliderHelper
{
	function includeAssets($params)
	{
		static $loaded;

		if ($loaded)
			return ;
			
		$loadJQuery = (bool)$params->get('includeJQuery', true);
		$noConflict = (bool)$params->get('noConflict', true);
		$theme = $params->get('theme', '');

		$doc =& JFactory::getDocument();
		$baseUri = JURI::root(true) . '/modules/mod_ariimageslider/mod_ariimageslider/js/';
		if ($loadJQuery) 
		{
			$jQueryVer = $params->get('jQueryVer', '1.4.4');
			$doc->addScript('http://ajax.googleapis.com/ajax/libs/jquery/' . $jQueryVer . '/jquery.min.js');

			if ($noConflict)
			{
				$doc->addScript($baseUri . 'jquery.noconflict.js');
			}
		}

		$doc->addScript($baseUri . 'jquery.nivo.slider.js');

		$filter =& JFilterInput::getInstance();
		$theme = $filter->clean($theme, 'WORD');
		if (empty($theme)) $theme = 'default';

		$doc->addStyleSheet($baseUri . 'themes/nivo-slider.css');
		$doc->addStyleSheet($baseUri . 'themes/' . $theme . '/style.css');
		if (@file_exists(JPATH_ROOT . DS . 'modules' . DS . 'mod_ariimageslider' . DS . 'mod_ariimageslider' . DS . 'js' . DS . 'themes' . DS . $theme . DS . 'style.ie6.css'))
		{
			$doc->addCustomTag(
				sprintf('<!--[if lt IE 7]><link rel="stylesheet" href="%s" type="text/css" /><![endif]-->',
					$baseUri . 'themes/' . $theme . '/style.ie6.css')
			);
		}
		
		if (@file_exists(JPATH_ROOT . DS . 'modules' . DS . 'mod_ariimageslider' . DS . 'mod_ariimageslider' . DS . 'js' . DS . 'themes' . DS . $theme . DS . 'style.ie.css'))
		{
			$doc->addCustomTag(
				sprintf('<!--[if IE]><link rel="stylesheet" href="%s" type="text/css" /><![endif]-->',
					$baseUri . 'themes/' . $theme . '/style.ie.css')
			);
		}

		$loaded = true;
	}
	
	function initSlider($id, $params)
	{
		AriImageSliderHelper::includeAssets($params);

		$clientParams = AriImageSliderHelper::getClientParams($params);
		$doc =& JFactory::getDocument();

		$doc->addScriptDeclaration(
			sprintf('jQuery(window).load(function() { var $ = window.jQueryNivoSlider || jQuery; $("#%1$s").nivoSlider(%2$s); });',
				$id,
				$clientParams ? AriJSONHelper::encode($clientParams) : '')
		);
		
		$width = intval($params->get('width', 300), 10);
		$height = intval($params->get('height'), 10);
		
		$styleDec = sprintf('#%1$s_wrapper,#%1$s{width:%2$dpx;height:%3$dpx;}',
			$id,
			$width,
			$height);
			
		if ($params->get('style'))
		{
			$extraStyles = trim($params->get('style'));
			$extraStyles = str_replace('{$id}', '#' . $id, $extraStyles);
			if (!empty($extraStyles))
				$styleDec .= $extraStyles;
		}
		
		$doc->addStyleDeclaration($styleDec);
	}
	
	function getClientParams($params)
	{
		$clientParams = array(
			'effect' => 'random',
			'slices' => 15,
			'animSpeed' => 500,
			'pauseTime' => 3000,
			'startSlide' => 0,
			'directionNav' => true,
			'directionNavHide' => true,
			'controlNav' => true,
			'keyboardNav' => true,
			'pauseOnHover' => true,
			'manualAdvance' => false,
			'captionOpacity' => 0.8,
			'disableClick' => false,
			'controlNavThumbs' => false
		);
		
		$sliderParams = array();
		foreach ($clientParams as $key => $value)
		{
			$param = $params->get('opt_' . $key, null);
			if (is_null($param))
				continue ;
				
			$param = AriUtils::parseValueBySample($param, $value);
			if ($value !== $param)
				$sliderParams[$key] = $param;
		}

		return $sliderParams;
	}
	
	function getSlides($params)
	{
		$slides = array();

		$pathList = AriImageSliderHelper::getPathList($params->get('path'));
		if (count($pathList) == 0)
			return $slides;

		$extraFields = array();
		$i18n = (bool)$params->get('i18n', false);
		$descrFile = trim($params->get('descrFile', ''));
		$processDescrFile = !empty($descrFile);
		$processSubDir = (bool)$params->get('subdir');
		$imgNumber = intval($params->get('imgNumber', 0), 10);
		$images = array();
		$sort = AriImageSliderHelper::getSortExpr($params);
		foreach ($pathList as $path)
		{
			if (empty($path))
				continue ;
			
			if (@is_file($path))
			{
				$images[] = $path;
				$path = dirname($path);
			}
			else
			{
				$folderImages = AriFolder::files(
					$path,
					'.(jpg|gif|jpeg|png|bmp|JPG|GIF|JPEG|BMP)$', 
					$processSubDir,
					true,
					$sort);

				if (is_array($folderImages) && count($folderImages) > 0)
				{
					if ($imgNumber > 0 && count($folderImages) > $imgNumber)
						$folderImages = array_slice($folderImages, 0, $imgNumber);

					$images = array_merge($images, $folderImages);
				}
			}
			
			if ($processDescrFile)
			{
				$folderExtraFields = AriAppUtils::getExtraFieldsFromINI($path, $descrFile, $processSubDir, true, $i18n);
				if (is_array($folderExtraFields) && count($folderExtraFields) > 0)
				{				
					$extraFields = array_merge($extraFields, $folderExtraFields);
				}
			}
		}
		
		$useThumbs = (bool)$params->get('imglist_useThumbs');
		$cachePath = $useThumbs ? AriImageSliderHelper::getCachePath() : null;
		$thumbPath = $params->get('imglist_thumbPath');
		$thumbWidth = intval($params->get('imglist_thumbWidth'), 10);
		$thumbHeight = intval($params->get('imglist_thumbHeight'), 10);
		$navThumbs = (bool)$params->get('opt_controlNavThumbs');
		$navThumbWidth = intval($params->get('imglist_navThumbWidth'), 10);
		$navThumbHeight = intval($params->get('imglist_navThumbHeight'), 10);
		$navThumbPath = $params->get('imglist_navThumbPath');
		$navCachePath = AriImageSliderHelper::getCachePath();
		$defaultDescr = $params->get('defaultDescription');
		$processDefaultDescr = $defaultDescr && strpos($defaultDescr, '{$') !== false;
		foreach ($images as $image)
		{
			$originalSlide = $slide = array(
				'src' => $image,
				'image' => str_replace('\\', '/', $image)
			);
			
			if ($processDescrFile && isset($extraFields[$image]))
				$slide = array_merge($extraFields[$image], $slide);
				
			if (empty($slide['description']) && $defaultDescr)
				$slide['description'] = $processDefaultDescr
					? str_replace(
						array('{$fileName}', '{$baseFileName}'), 
						array(basename($image), JFile::stripExt(basename($image))), 
						$defaultDescr)	
					: $defaultDescr;
				
			if ($useThumbs)
				$slide = AriImageSliderHelper::generateThumbnail($slide, $thumbWidth, $thumbHeight, $thumbPath, $cachePath);
				
			if ($navThumbs)
			{
				$navThumb = AriImageSliderHelper::generateThumbnail($originalSlide, $navThumbWidth, $navThumbHeight, $navThumbPath, $navCachePath);
				$slide['nav'] = $navThumb;
			}
			
			
			$slides[] = $slide;
		}

		return $slides;
	}

	function prepareSlides($slides, $params)
	{
		$newSlides = array();
		
		$target = $params->get('linkTarget', '_self');
		$baseUri = JURI::base(true);
		$lightboxEngine = AriImageSliderHelper::getLightboxEngine($params);
		$lightboxGroup = uniqid('cc_');
		foreach ($slides as $slide)
		{
			$isLink = !empty($slide['link']);
			$description = isset($slide['description']) ? $slide['description'] : '';
			$altText = isset($slide['alt']) ? $slide['alt'] : '';
		
			$lnkAttrs = null;
			$imgAttrs = array('src' => $baseUri . '/' . $slide['image'], 'alt' => $altText, 'title' => $description, 'class' => 'imageslider-item');
			if (!empty($slide['width'])) $imgAttrs['width'] = $slide['width'];
			if (!empty($slide['height'])) $imgAttrs['height'] = $slide['height'];
			if ($isLink)
			{
				$lnkAttrs = array('href' => $slide['link'], 'target' => $target);
				if ($description)
					$lnkAttrs['title'] = $description;
					
				if (!is_null($lightboxEngine))
					list($lnkAttrs, $imgAttrs) = $lightboxEngine->modifyAttrs($lnkAttrs, $imgAttrs, $lightboxGroup, $params);
			}
					
			$slide['lnkAttrs'] = $lnkAttrs;
			$slide['imgAttrs'] = $imgAttrs;
			$newSlides[] = $slide;
		}
		
		return $newSlides;
	}

	function generateThumbnail($slide, $thumbWidth, $thumbHeight, $thumbPath, $cachePath)
	{
		$img = $slide['src'];
		$imgUri = $slide['image'];
		$thumbFile = null;
		
		if ($thumbPath)
		{
			$pathInfo = pathinfo($img);
			$thumbImg = $pathInfo['dirname'] . DS .  str_replace('{$fileName}', $pathInfo['basename'], $thumbPath);
			if (@file_exists(JPATH_ROOT . DS . $thumbImg) && @is_file(JPATH_ROOT . DS . $thumbImg))
			{
				$thumbFile = $thumbImg;
			}
		}

		if (is_null($thumbFile))
		{
			$thumbName = AriImageHelper::generateThumbnail(
				JPATH_ROOT . DS . $img, 
				JPATH_ROOT . DS . $cachePath, 
				'ais',
				$thumbWidth,
				$thumbHeight);
			if ($thumbName)
			{
				$thumbFile = $cachePath . DS . $thumbName;
			}
			else
			{
				$thumbFile = $img;
			}
		}

		$slide['src'] = $thumbFile;
		$slide['image'] = str_replace('\\', '/', $thumbFile);
		if (empty($slide['link']))
			$slide['link'] = $imgUri;
			
		$thumbSize = AriImageHelper::getThumbnailDimension(JPATH_ROOT . DS . $thumbFile, $thumbWidth, $thumbHeight);
		if (!empty($thumbSize['w'])) $slide['width'] = $thumbSize['w'];
		if (!empty($thumbSize['h'])) $slide['height'] = $thumbSize['h'];
		
		return $slide;
	}
	
	function getCachePath()
	{
		$cacheDir = 'cache';
		$extCacheDir = $cacheDir . DS . 'mod_ariimageslider';
		if (@file_exists($extCacheDir) && is_dir($extCacheDir))
		{
			$cacheDir = $extCacheDir;
		}
		
		return $cacheDir;
	}
	
	function getSortExpr($params)
	{
		$sortBy = $params->get('sortBy');
		if (empty($sortBy) || !in_array($sortBy, array('filename', 'modified', 'random')))
			return null;
			
		return array(
			'sortBy' => $sortBy, 
			'sortDir' => ($params->get('sortDir') == 'desc' ? 'desc' : 'asc')
		);
	}
	
	function getPathList($path)
	{
		$pathList = array();
		if (empty($path))
			return $pathList;

		$pathList = explode("\n", $path);
		array_walk($pathList, array('AriFolder', 'clean'));
		$pathList = array_unique($pathList);
		
		return $pathList;
	}

	function getLightboxEngine($params)
	{
		$engine = null;
		$engineName = ucfirst(JFilterInput::clean($params->get('lightboxEngine'), 'WORD'));
		if (empty($engineName))
			return null;
		
		AriKernel::import('ImageSlider.Lightbox.' . $engineName);
		
		$className = $engineName . 'ImageSliderEngine';
		if (class_exists($className))
		{
			$engine = new $className();
			if (!$engine->preCheck())
			{
				$engine = null;
			}
		}
		
		return $engine;
	}
}
?>
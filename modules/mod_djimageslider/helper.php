<?php
/**
* @version 1.2 stable
* @package DJ Image Slider
* @subpackage DJ Image Slider Module
* @copyright Copyright (C) 2010 Blue Constant Media LTD, All rights reserved.
* @license http://www.gnu.org/licenses GNU/GPL
* @author url: http://design-joomla.eu
* @author email contact@design-joomla.eu
* @developer Szymon Woronowski - szymon.woronowski@design-joomla.eu
*
*
* DJ Image Slider is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* DJ Image Slider is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with DJ Image Slider. If not, see <http://www.gnu.org/licenses/>.
*
*/

// no direct access
defined('_JEXEC') or die ('Restricted access');

class modDJImageSliderHelper
{
    function getImagesFromFolder(&$params) {
    	
    	if(!is_numeric($max = $params->get('max_images'))) $max = 20;
        $folder = $params->get('image_folder');
        if(!$dir = @opendir($folder)) return null;
        while (false !== ($file = readdir($dir)))
        {
            if (preg_match('/.+\.(jpg|jpeg|gif|png)$/', $file)) $files[] = $file;						
        }
        closedir($dir);
        if($params->get('sort_by')) natcasesort($files);
		else shuffle($files);

		$images = array_slice($files, 0, $max);
		
		$target = modDJImageSliderHelper::getSlideTarget($params->get('link'));
		
		foreach($images as $image) {
			$slides[] = (object) array('title'=>'', 'description'=>'', 'image'=>$folder.'/'.$image, 'link'=>$params->get('link'), 'alt'=>$image, 'target'=>$target);
		}
				
		return $slides;
    }
	
	function getImagesFromDJImageSlider(&$params) {
		
		if(!is_numeric($max = $params->get('max_images'))) $max = 20;
        $catid = $params->get('category');
		$db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__djimageslider WHERE catid='.$catid.' AND published=1 ORDER BY ordering ASC';
		$db->setQuery($query);
		$slides = $db->loadObjectList();
		
        if(!$params->get('sort_by')) shuffle($slides);
		
		$slides = array_slice($slides, 0, $max);
		
		foreach($slides as $slide){
			$slide->link = modDJImageSliderHelper::getSlideLink($slide->params);
			$slide->description = modDJImageSliderHelper::getSlideDescription($slide, $params->get('limit_desc'));
			$slide->alt = $slide->title;
			$slide->target = modDJImageSliderHelper::getSlideTarget($slide->link);
		}
		
		return $slides;
    }
	
	function getSlideLink(&$sparams) {
		$slide_params = new JParameter($sparams);
		$link = '';
		$db = &JFactory::getDBO();
		switch($slide_params->get('targetswitch', -1)) {
			case 0:
				if ($menuid = $slide_params->get('target',0)) {
					$menu =& JSite::getMenu();
					$menuitem = $menu->getItem($menuid);
					if($menuitem) switch($menuitem->type) {
						case 'component': 
							$link = JRoute::_($menuitem->link.'&Itemid='.$menuid);
							break;
						case 'url':
						case 'menulink':
							$link = JRoute::_($menuitem->link);
							break;
					}	
				}
				break;
			case 1:
				if($itemurl = $slide_params->get('targeturl',0)) {
					$link = JRoute::_($itemurl);
				}
				break;
			case 2:
				if ($artid = $slide_params->get('id',$slide_params->get('targetart',0))) {
					global $mainframe;
					$link = JRoute::_('index.php?option=com_content&view=article&id='.$artid.'&Itemid='.$mainframe->getItemid($artid));
				}
				break;
			case 3:
				if ($prodid = $slide_params->get('targetvmprod',0)) {
					$query = 'SELECT c.* FROM #__vm_category as c, #__vm_product_category_xref as x WHERE x.product_id='.$prodid.' AND c.category_id=x.category_id LIMIT 1';
					$db->setQuery($query);
					$category = $db->loadObject();
					$prodItemid = modDJImageSliderHelper::getProductItemid($prodid,$category->category_id);
					$link = JRoute::_('index.php?page=shop.product_details&flypage='.$category->category_flypage.'&product_id='.$prodid.'&category_id='.$category->category_id.'&option=com_virtuemart&Itemid='.$prodItemid);
				}
				break;
			case 4:
				if ($prodid = $slide_params->get('targetdjc2prod',0)) {
					$query = 'SELECT * FROM #__djc2_items WHERE id='.$prodid.' LIMIT 1';
					$db->setQuery($query);
					$item = $db->loadObject();
					if($item){
						include_once(JPATH_BASE.DS.'components'.DS.'com_djcatalog2'.DS.'helpers'.DS.'route.php');
						$link = JRoute::_(DJCatalogHelperRoute::getItemRoute($prodid, $item->cat_id));
					}
				}
		}
		
		return $link;
	}
	
	function getSlideDescription($slide, $limit) {
		$sparams = new JParameter($slide->params);
		if($sparams->get('targetswitch')==2 && !$slide->description){ // if article and no description then get introtext as description
			$artid = $sparams->get('id',$sparams->get('targetart',0));
			$db = &JFactory::getDBO();
			$query = 'SELECT * FROM #__content WHERE id='.$artid.' LIMIT 1';
			$db->setQuery($query);
			$article = $db->loadObject();
			if($article) {
				$slide->description = $article->introtext;
			}
		}
		if($sparams->get('targetswitch')==3 && !$slide->description){ // if vm product and no description then get product_s_desc as description
			$prodid = $sparams->get('targetvmprod');
			$db = &JFactory::getDBO();
			$query = 'SELECT * FROM #__vm_product WHERE product_id='.$prodid.' LIMIT 1';
			$db->setQuery($query);
			$prod = $db->loadObject();
			if($prod) {
				$slide->description = $prod->product_s_desc;
				if(!$slide->description) $slide->description = $prod->product_desc;
			}
		}
		if($sparams->get('targetswitch')==4 && !$slide->description){ // if article and no description then get introtext as description
			$prodid = $sparams->get('targetdjc2prod');
			$db = &JFactory::getDBO();
			$query = 'SELECT * FROM #__djc2_items WHERE id='.$prodid.' LIMIT 1';
			$db->setQuery($query);
			$item = $db->loadObject();
			if($item) {
				$slide->description = $item->intro_desc;
				if(!$slide->description) $slide->description = $item->description;
			}
		}
		$desc = strip_tags($slide->description);
		if($limit && $limit < strlen($desc)) {
			$limit = strpos($desc, ' ', $limit);
			$desc = substr($desc, 0, $limit);
			if(preg_match('/[A-Za-z0-9]$/', $desc)) $desc.=' ...';
		} else { // no limit or limit greater than description
			$desc = $slide->description;
		}
		
		$desc = nl2br($desc);

		return $desc;
	}
	
	function getProductItemid($prodid,$catid) {
		$db = &JFactory::getDBO();
		$query = "SELECT id FROM #__menu WHERE link='index.php?option=com_virtuemart' AND params like '%product_id=$prodid%' AND published=1 LIMIT 1";
		$db->setQuery($query);
		$vm_itemid = $db->loadResult();
		if($vm_itemid) return $vm_itemid;
		
		$query = "SELECT id FROM #__menu WHERE link='index.php?option=com_virtuemart' AND params like '%category_id=$catid%' AND published=1 LIMIT 1";
		$db->setQuery($query);
		$vm_itemid = $db->loadResult();
		if($vm_itemid) return $vm_itemid;
		
		$query = "SELECT id FROM #__menu WHERE link='index.php?option=com_virtuemart' AND published=1 LIMIT 1";
		$db->setQuery($query);
		$vm_itemid = $db->loadResult();
		if($vm_itemid) return $vm_itemid;
		
		return 0;
	}

	function getAnimationOptions(&$params) {
		$effect = $params->get('effect');
		$effect_type = $params->get('effect_type');
		if(!is_numeric($duration = $params->get('duration'))) $duration = 0;
		if(!is_numeric($delay = $params->get('delay'))) $delay = 3000;
		$autoplay = $params->get('autoplay');
		if($params->get('slider_type')==2 && !$duration) {
			$transition = 'linear';
			$duration = 600;
		} else switch($effect){
			case 'Linear':
				$transition = 'linear';
				if(!$duration) $duration = 600;
				break;
			case 'Circ':
			case 'Expo':
			case 'Back':
				if(!$effect_type) $transition = $effect.'.easeInOut';
				else $transition = $effect.'.'.$effect_type;
				if(!$duration) $duration = 1000;
				break;
			case 'Bounce':
				if(!$effect_type) $transition = $effect.'.easeOut';
				else $transition = $effect.'.'.$effect_type;
				if(!$duration) $duration = 1200;
				break;
			case 'Elastic':
				if(!$effect_type) $transition = $effect.'.easeOut';
				else $transition = $effect.'.'.$effect_type;
				if(!$duration) $duration = 1500;
				break;
			case 'Cubic':
			default: 
				if(!$effect_type) $transition = 'Cubic.easeInOut';
				else $transition = 'Cubic.'.$effect_type;
				if(!$duration) $duration = 800;
		}
		$delay = $delay + $duration;
		$options = "{auto: $autoplay, transition: Fx.Transitions.$transition, duration: $duration, delay: $delay}";
		return $options;
	}
	
	function getSlideTarget($link) {
		
		if(preg_match("/^http/",$link) && !preg_match("/^".str_replace(array('/','.','-'), array('\/','\.','\-'),JURI::base())."/",$link)) {
			$target = '_blank';
		} else {
			$target = '_self';
		}
		
		return $target;
	}
	
	function getNavigation(&$params, &$mid) {
		
		$prev = $params->get('left_arrow');
		$next = $params->get('right_arrow');
		$play = $params->get('play_button');
		$pause = $params->get('pause_button');
		
		if($params->get('slider_type')==1) {			
			if(empty($prev) || !file_exists(JPATH_ROOT.DS.$prev)) $prev = JURI::base().'/modules/mod_djimageslider/assets/up.png';			
			if(empty($next) || !file_exists(JPATH_ROOT.DS.$next)) $next = JURI::base().'/modules/mod_djimageslider/assets/down.png';
		} else {			
			if(empty($prev) || !file_exists(JPATH_ROOT.DS.$prev)) $prev = JURI::base().'/modules/mod_djimageslider/assets/prev.png';			
			if(empty($next) || !file_exists(JPATH_ROOT.DS.$next)) $next = JURI::base().'/modules/mod_djimageslider/assets/next.png';
		}
		if(empty($play) || !file_exists(JPATH_ROOT.DS.$play)) $play = JURI::base().'/modules/mod_djimageslider/assets/play.png';
		if(empty($pause) || !file_exists(JPATH_ROOT.DS.$pause)) $pause = JURI::base().'/modules/mod_djimageslider/assets/pause.png';
		
		$navi = (object) array('prev'=>$prev,'next'=>$next,'play'=>$play,'pause'=>$pause);
		
		return $navi;
	}
	
	function getStyleSheet(&$params, &$mid) {
		if(!is_numeric($slide_width = $params->get('image_width'))) $slide_width = 240;
		if(!is_numeric($slide_height = $params->get('image_height'))) $slide_height = 160;
		if(!is_numeric($max = $params->get('max_images'))) $max = 20;
		if(!is_numeric($count = $params->get('visible_images'))) $count = 2;
		if(!is_numeric($spacing = $params->get('space_between_images'))) $spacing = 0;
		if($count<1) $count = 1;
		if($count>$max) $count = $max;
		if(!is_numeric($desc_width = $params->get('desc_width')) || $desc_width > $slide_width) $desc_width = $slide_width;
		if(!is_numeric($desc_bottom = $params->get('desc_bottom'))) $desc_bottom = 0;
		if(!is_numeric($desc_left = $params->get('desc_horizontal'))) $desc_left = 0;
		if(!is_numeric($arrows_top = $params->get('arrows_top'))) $arrows_top = 100;
		if(!is_numeric($arrows_horizontal = $params->get('arrows_horizontal'))) $arrows_horizontal = 5;
		if(!$params->get('show_buttons')) $play_pause = 'top: -99999px;'; else $play_pause = '';
		if(!$params->get('show_arrows')) $arrows = 'top: -99999px;'; else $arrows = '';
		if(!$params->get('show_custom_nav')) $custom_nav = 'display: none;'; else $custom_nav = '';
		
		switch($params->get('slider_type')){
			case 2:
				$slider_width = $slide_width;
				$slider_height = $slide_height;
				$image_width = $slide_width.'px';
				$image_height = 'auto';
				$padding_right = 0;
				$padding_bottom = 0;
				break;
			case 1:
				$slider_width = $slide_width;
				$slider_height = $slide_height * $count + $spacing * ($count - 1);
				$image_width = 'auto';
				$image_height = $slide_height.'px';
				$padding_right = 0;
				$padding_bottom = $spacing;
				break;
			case 0:
			default:
				$slider_width = $slide_width * $count + $spacing * ($count - 1);
				$slider_height = $slide_height;
				$image_width = $slide_width.'px';
				$image_height = 'auto';
				$padding_right = $spacing;
				$padding_bottom = 0;
				break;
		}
		
		if($params->get('fit_to')==1) {
			$image_width = $slide_width.'px';
			$image_height = 'auto';
		} else if($params->get('fit_to')==2) {
			$image_width = 'auto';
			$image_height = $slide_height.'px';
		}
				
		$css = '
		/* Styles for DJ Image Slider with module id '.$mid.' */
		#djslider-loader'.$mid.' {
			margin: 0 auto;
			position: relative;
			height: '.$slider_height.'px; 
			width: '.$slider_width.'px;
		}
		#djslider'.$mid.' {
			margin: 0 auto;
			position: relative;
			height: '.$slider_height.'px; 
			width: '.$slider_width.'px;
			display: none;
		}
		#slider-container'.$mid.' {
			position: absolute;
			overflow:hidden;
			left: 0; 
			top: 0;
			height: '.$slider_height.'px; 
			width: '.$slider_width.'px;			
		}
		#djslider'.$mid.' ul#slider'.$mid.' {
			margin: 0 !important;
			padding: 0 !important;
			border: 0 !important;
		}
		#djslider'.$mid.' ul#slider'.$mid.' li {
			list-style: none outside !important;
			float: left;
			margin: 0 !important;
			border: 0 !important;
			padding: 0 '.$padding_right.'px '.$padding_bottom.'px 0 !important;
			position: relative;
			height: '.$slide_height.'px;
			width: '.$slide_width.'px;
			background: none;
			overflow: hidden;
		}
		#slider'.$mid.' li img {
			width: '.$image_width.';
			height: '.$image_height.';
			border: 0 !important;
		}
		#slider'.$mid.' li a img, #slider'.$mid.' li a:hover img {
			border: 0 !important;
		}
		
		/* Slide description area */
		#slider'.$mid.' .slide-desc {
			position: absolute;
			bottom: '.($desc_bottom + $padding_bottom).'px;
			left: '.$desc_left.'px;
			width: '.$desc_width.'px;
		}
		#slider'.$mid.' .slide-desc-in {
			position: relative;
		}
		#slider'.$mid.' .slide-desc-bg {
			position:absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
		}
		#slider'.$mid.' .slide-desc-text {
			position: relative;
		}
		#slider'.$mid.' .slide-desc-text h3 {
			display: block !important;
		}
		
		/* Navigation buttons */
		#navigation'.$mid.' {
			position: relative;
			top: '.$arrows_top.'px; 
			margin: 0 '.$arrows_horizontal.'px;
			text-align: center !important;
		}
		#prev'.$mid.' {
			cursor: pointer;
			display: block;
			position: absolute;
			left: 0;
			'.$arrows.'
		}
		#next'.$mid.' {
			cursor: pointer;
			display: block;
			position: absolute;
			right: 0;
			'.$arrows.'
		}
		#play'.$mid.', 
		#pause'.$mid.' {
			cursor: pointer;
			display: block;
			position: absolute;
			left: 47%;
			'.$play_pause.'
		}
		#cust-navigation'.$mid.' {
			position: absolute;
			top: 10px;
			right: 10px;
			z-index: 15;
			'.$custom_nav.'
		}
		';
		
		return $css;
	}

}

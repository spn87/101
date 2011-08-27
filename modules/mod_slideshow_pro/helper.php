<?php
/**
* @version		$Id: default.php 00005 2009-11-10 00:00:00 umitkenan $
* @package		Joomla
* @subpackage	SlideShow Pro Module
* @link 		http://www.jt.gen.tr
* @copyright	Copyright (C) Joomla Türkçe Eðitim ve Destek Sitesi. http://www.jt.gen.tr 
* @license		GNU/GPL
*/

class modSlideShowProHelper
{
    function getParameterList( &$params )
    {
		// Loading images, urls, titles, styles, options, etc..
		$this->image 					= explode ( "\n", trim ( $params->get ( 'images' ) ) );
		$this->url 						= explode ( "\n", trim ( $params->get ( 'urls' ) ) );
		$this->title 					= htmlspecialchars ( trim ( $params->get ( 'titles' ) ) );
		$this->title 					= explode ( "\n", $this->title );
		$this->folder					= trim ( $params->get ( 'folder' ) );
		$this->showallimages			= $params->get( 'showallimages', 0 );
		$this->target					= trim ( $params->get ( 'target', '_blank' ) );
		$this->linked					= $params->get( 'linked', 1 );

		// If adding "http" is YES
		if (trim ( $params->get ( 'addhttp' ) )) {
			for ( $i=0 ; $i < count($this->image) ; $i++ )
				$this->url[$i]="http://".$this->url[$i]; }

		$this->imgwidth					= trim ( $params->get ( 'imgwidth', '170px' ) );
		$this->imgheight				= trim ( $params->get ( 'imgheight', '128px' ) );
		$this->imgspace					= trim ( $params->get ( 'imgspace', '2px' ) );
		if ($this->imgspace != 0 || $this->imgspace != '' || $this->imgspace != null) $this->imgspace = 'margin-right: '. $this->imgspace .';';
		else $this->imgspace = '';

		$this->imgborder				= trim ( $params->get ( 'imgborder', 0 ) );
		$this->imgbordersize			= trim ( $params->get ( 'imgbordersize', '5px' ) );
		$this->imgbordercolor			= trim ( $params->get ( 'imgbordercolor', '#eee' ) );

		if(strpos($this->imgwidth,'px') === false && strpos($this->imgwidth,'%') === false) $this->imgwidth = 0;
		if(strpos($this->imgheight,'px') === false && strpos($this->imgheight,'%') === false) $this->imgheight = 0;

		if ($this->imgborder == 1) {
			if(strpos($this->imgwidth,'px')) $this->imgwidth = ((str_replace('px','',$this->imgwidth)) - ($this->imgbordersize * 2) ).'px';
			if(strpos($this->imgheight,'px')) $this->imgheight = ((str_replace('px','',$this->imgheight)) - ($this->imgbordersize * 2) ).'px';
			if(strpos($this->imgwidth,'%')) $this->imgwidth = ((str_replace('%','',$this->imgwidth)) - ($this->imgbordersize / 2)).'%';
			if(strpos($this->imgheight,'%')) $this->imgheight = ((str_replace('%','',$this->imgheight)) - ($this->imgbordersize / 2)).'%';
		}
		
		$this->loadjquery				= trim ( $params->get ( 'loadjquery', 1 ) );
		$this->boxname 					= trim ( $params->get ( 'boxname', 'slideshowbox' ) );
		$this->boxwidth					= trim ( $params->get ( 'boxwidth', '100%' ) );
		$this->boxheight				= trim ( $params->get ( 'boxheight', '100%' ) );

		// Advanced parameters
		$this->layout	 				= trim ( $params->get ( 'layout', 'horizontal' ) );
		$this->verticalforjs 			= ''; 
		$this->verticalfordiv 			= ''; 
		if ($this->layout == 'horizontal') $this->layout = 'vertical: false,';
		else 
		{ 
			$this->layout = 'vertical: true,';
		}
		
		$this->easing	 				= trim ( $params->get ( 'easing', '' ) );
		if ($this->easing != '' && $this->easing != null) $this->easing = 'easing: "'. $this->easing .'",';
		
		$this->speed	 				= trim ( $params->get ( 'speed', 1000 ) );
		$this->visible	 				= trim ( $params->get ( 'visible', 3 ) );
		$this->delay 					= trim ( $params->get ( 'delay', 500 ) );
		if ($this->delay == 0 && $this->delay == null && $this->delay == '') $this->delay = 500;
		
		$this->hoverPause 				= trim ( $params->get ( 'hoverPause', 'off' ) );
		if ($this->hoverPause == 'off') $this->hoverPause = 'hoverPause: false';
		else $this->hoverPause = 'hoverPause: true';
		
		// Show all images
		if ($this->showallimages) {
			// Directory SlideShow
			// if subdirectory parameter is yes
			$jpgimages = glob("".$this->folder."/*.jpg");
			$pngimages = glob("".$this->folder."/*.png");
			$gifimages = glob("".$this->folder."/*.gif");

			// Generating image array
			// Adding jpeg files to (directory) slideshow
			$this->image = $jpgimages;

			// Adding png files to (directory) slideshow
			$j=0;
			for ($i = count($jpgimages); $i < count($jpgimages)+count($pngimages); $i++) {
				$this->image[$i]=$pngimages[$j];
				$j=$j+1;
			}
		
			// Adding gif files to (directory) slideshow
			$j=0;
			for ($i = count($this->image); $i < count($jpgimages)+count($pngimages)+count($gifimages); $i++) {
				$this->image[$i]=$gifimages[$j];
				$j=$j+1; 
			}	
		}

		// SlideShow Content - Loop
		for ( $i=0 ; $i < count($this->image) ; $i++ ) {
			// Preparing Titles
			$this->alt[$i] 				= $this->title[$i] ? ' alt="'. $this->title[$i] .'"' : '';
			$this->alttitle[$i] 		= $this->title[$i] ? ' title="'. $this->title[$i] .'"' : '';

			// Preparing Links
			$this->imagelinkstart[$i] 	= $this->linked ? '<a href="'. $this->url[$i] .'" target="'. $this->target .'">' : '<a href="javascript:void(0);">';
			$this->imagelinkend		 	= '</a>';
			
			// Show Only Entered Images
			if (!$this->showallimages) {
				// External Image Resource
				if (strstr($this->image[$i],'<ext>')) {
					$this->image[$i] = str_replace('<ext>','',$this->image[$i]);
					$this->imagewithpath[$i] = '<img src="'. $this->image[$i] . '" border="0"'. $this->alt[$i] . $this->alttitle[$i] .' />';
				}
				// Internal Image Resource
				else $this->imagewithpath[$i] = '<img src="'.JURI::root() . $this->folder . '/' . $this->image[$i] . '" border="0"'. $this->alt[$i] . $this->alttitle[$i] .' />';			
			}
			// Show All Images in the folder
			else $this->imagewithpath[$i] = '<img src="'.JURI::root() . $this->image[$i] . '" border="0"'. $this->alt[$i] . $this->alttitle[$i] .' />';
			
			// Prepared SlideShow (Content) Image:
			$this->slideshowcontent[$i]	= '<li>'.$this->imagelinkstart[$i].$this->imagewithpath[$i].$this->imagelinkend.'</li>';
		}

		// SlideShow Pro Footer
		$this->slideshowprofooter = '';
		if ( $params->get ( 'slideshowprofooter' ) == null || $params->get ( 'slideshowprofooter' ) == ''  ) $params->set ( 'slideshowprofooter', 1 );
		if ( $params->get ( 'slideshowprofooter' ) == 1 )
			$this->slideshowprofooter = '<div id="'.$this->boxname.'footer">'.JText::_( 'SLIDESHOW PRO MODULE BY JT').'</div><div class="JT-ClearBox"></div>';

		// Notifications, warnings and errors
		if ( $this->boxname == null || $this->boxname == ''  ) JError::raiseWarning('ERROR_CODE', JText::_('ERRORBOXNAME'));
		if ( $this->image[0] == null || $this->image[0] == '' ) JError::raiseWarning('ERROR_CODE', JText::_('ERRORIMAGE'));

		// Joomla Factory
		$document =& JFactory::getDocument();

		// Preparing CSS style
		// Clear Box
		$css = ' div.JT-ClearBox { display: block; height: 0; clear: both; visibility: hidden; } ' . "\n";
		// JT SlideShow Footer
		$css = $css . ' DIV#'.$this->boxname.'footer { display:block; padding-top: 10px; font-family: Tahoma,Verdana,sans-serif; font-size: 8px; font-weight: bold; } ' . "\n";
		// SlideShow Box
		$css = $css . ' DIV#'.$this->boxname.'wrapper { width: '. $this->boxwidth .'; height: '. $this->boxheight .'; overflow: hidden; margin: 0px auto; '.$this->slideshowboxposition.' } ' . "\n";
		// SlideShow Box - List
		$css = $css . ' .'.$this->boxname.' ul li { list-style:none; display:block; } ' . "\n";
		// SlideShow Box - Images
		$css = $css . ' .'.$this->boxname.' li img { '.$this->imgspace.' width: '.$this->imgwidth.'; height: '.$this->imgheight.'; } ' . "\n";
		if ($this->imgborder == 1) $css = $css . ' .'.$this->boxname.' li img { border-width: '. $this->imgbordersize .'; border-style: solid; border-color: '. $this->imgbordercolor .'; } ' . "\n";
		
		// loading jQuery
		$jQuery = '';
		if ($this->loadjquery == 1)
			$jQuery = '<script src = "'. JURI::root() .'modules/mod_slideshow_pro/scripts/jquery.js" type="text/javascript"></script>' . "\n";
		$jQuery .= '<script src = "'. JURI::root() .'modules/mod_slideshow_pro/scripts/jcarousellite_1.0.1c4.js" type="text/javascript"></script>';
		$jQuery .= '<script src = "'. JURI::root() .'modules/mod_slideshow_pro/scripts/jquery.easing.1.3.js" type="text/javascript"></script>';
		$jQuery .= '<script src = "'. JURI::root() .'modules/mod_slideshow_pro/scripts/jquery.easing.compatibility.js" type="text/javascript"></script>';
		
		// Apply CSS Styles & JavaScript
		$document->addCustomTag($jQuery);
		$document->addCustomTag( '<script type="text/javascript">jQuery.noConflict();</script>' );
		$document->addStyleDeclaration($css);
	}
}
<?php
/**
* @Copyright Copyright (C) 2010 Alfred Bösch
* @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
**/

defined( '_JEXEC' ) or die( 'Restricted access' );
$mainframe->registerEvent( 'onPrepareContent', 'pluginBoVideoJS' );

function pluginBoVideoJS(&$row, &$params) {
	
	$plugin =& JPluginHelper::getPlugin('content', 'bo_videojs');
  	$pluginParams = new JParameter( $plugin->params );
	
	$hits = preg_match_all('#{bo_videojs\s*(.*?)}#s', $row->text, $matches);
	
	if (!empty($hits)) {
		$document =& JFactory::getDocument();
		$document->addScript(JURI::base().'plugins'.DS.'content'.DS.'bo_videojs'.DS.'video.js');

		for ($i=1; $i<=$hits; $i++) {
			$document->addScriptDeclaration('VideoJS.DOMReady(function(){
				var plg_player_'.$i.' = VideoJS.setup("plg_bo_videojs_'.$i.'", {
					autoplay:				'.$pluginParams->get('autoplay', 'false').',
					preload:				'.$pluginParams->get('preload', 'true').',
					useBuiltInControls:		'.$pluginParams->get('useBuiltInControls', 'false').',
					controlsBelow: 			'.$pluginParams->get('controlsBelow', 'false').',
					controlsAtStart:		'.$pluginParams->get('controlsAtStart', 'false').',
					controlsHiding: 		'.$pluginParams->get('controlsHiding', 'true').',
					defaultVolume: 			'.$pluginParams->get('defaultVolume', '0.85').',
					playerFallbackOrder:	['.$pluginParams->get('playerFallbackOrder', '"html5", "flash", "links"').'],
					flashPlayerVersion: 	'.$pluginParams->get('flashPlayerVersion', '9').'
				});
		    });');
		}
	
		$document->addStyleSheet(JURI::base().'plugins'.DS.'content'.DS.'bo_videojs'.DS.'video-js.css');
		if ($pluginParams->get('skin') != 'default') {
			$document->addStyleSheet(JURI::base().'plugins'.DS.'content'.DS.'bo_videojs'.DS.'skins'.DS.$pluginParams->get('skin').'.css');
		}
	} else {
		return false;
	}
	
	for ($i=0; $i<$hits; $i++) {
		$videoParams = $matches[1][$i];
		$videoParamsList = contentBoVideoJS_getParams($videoParams, $pluginParams);
		$html = contentBoVideoJS_createHTML($i+1, $pluginParams, $videoParamsList);
		$pattern = str_replace('[', '\[', $matches[0][$i]);
		$pattern = str_replace(']', '\]', $pattern);
		$pattern = str_replace('/', '\/', $pattern);
    	$row->text = preg_replace('/'.$pattern.'/', $html, $row->text, 1);
	}
	
	return true;	
	
}

function contentBoVideoJS_getParams($videoParams, $pluginParams) {
	
	$videoParamsList['width'] 		= $pluginParams->get('width');
	$videoParamsList['height'] 		= $pluginParams->get('height');
	$videoParamsList['autoplay']	= $pluginParams->get('autoplay');
	$videoParamsList['loop']		= $pluginParams->get('loop');
	$videoParamsList['video_mp4']	= $pluginParams->get('video_mp4');
	$videoParamsList['video_webm']	= $pluginParams->get('video_webm');
	$videoParamsList['video_ogg'] 	= $pluginParams->get('video_ogg');
	$videoParamsList['image'] 		= $pluginParams->get('image');
	$videoParamsList['flash'] 		= $pluginParams->get('flash');
	
	$items = explode(' ', $videoParams);
	
	foreach ($items as $item) {
		if ($item != '') {
			$item	= explode('=', $item);
			$name 	= $item[0];
			$value	= strtr($item[1], array('['=>'', ']'=>''));
			$videoParamsList[$name] = $value;
		}
	}
	
	return $videoParamsList;
}

function contentBoVideoJS_createHTML($id, &$pluginParams, &$videoParamsList) {
	
	$width 		= $videoParamsList['width'];
	$height 	= $videoParamsList['height'];
	$autoplay	= $videoParamsList['autoplay'];
	$loop		= $videoParamsList['loop'];
	$video_mp4	= $videoParamsList['video_mp4'];
	$video_webm	= $videoParamsList['video_webm'];
	$video_ogg	= $videoParamsList['video_ogg'];
	$flash		= $videoParamsList['flash'];
	$image 		= $videoParamsList['image'];
	$skin		= '';
	$wmode		= $pluginParams->get('wmode', 'default');
	$uri_flash	= '';
	$uri_image	= '';
	
	// Add URI for local flash video
	if (stripos($flash, 'http://') === false) {
		$uri_flash = JURI::base();		
	}
	
	// Add URI for local flash image
	if (stripos($image, 'http://') === false) {
		$uri_image = JURI::base();		
	}
	
	if ($pluginParams->get('skin', 'default') != 'default') {
		$skin 	= ' '.$pluginParams->get('skin').'-css';
	}
	
	// Preload works for both HTML and Flash
	if ($pluginParams->get('preload', '1') == '1') {
		$preload_html 	= ' preload="auto"';
		$preload_flash	= '"autoBuffering":true';
	} else {
		$preload_html 	= ' preload="none"';
		$preload_flash	= '"autoBuffering":false';
	}
	
	// Autoplay works for both HTML and Flash
	if ($autoplay == "true" || $autoplay == "1") {
		$autoplay_html 	= ' autoplay="autoplay"';
		$autoplay_flash	= '"autoPlay":true';
	} else {
		$autoplay_html 	= '';
		$autoplay_flash	= '"autoPlay":false';
	}
	
	// Actually loop works only for HTML
	if ($loop == "true" || $loop == "1") {
		$loop_html		= ' loop="loop"';
	} else {
		$loop_html 		= '';
	}
	
	// HTML output
	$html = '<div class="video-js-box'.$skin.'">
		<video id="plg_bo_videojs_'.$id.'" class="video-js" width="'.$width.'" height="'.$height.'" controls="controls"'.$autoplay_html.$preload_html.$loop_html.' poster="'.$image.'">';
	
	if ($video_mp4 != "0") {
		$html .= '<source src="'.$video_mp4.'" type=\'video/mp4; codecs="avc1.42E01E, mp4a.40.2"\' />';
	}
	
	if ($video_webm != "0") {
		$html .= '<source src="'.$video_webm.'" type=\'video/webm; codecs="vp8, vorbis"\' />';
	}

	if ($video_ogg != "0") {
		$html .= '<source src="'.$video_ogg.'" type=\'video/ogg; codecs="theora, vorbis"\' />';
	}
	
	if ($flash != "0") {
		$html .= '<object id="plg_flash_fallback_'.$id.'" class="vjs-flash-fallback" width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" data="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf">
        		<param name="movie" value="http://releases.flowplayer.org/swf/flowplayer-3.2.1.swf" />';
		if ($wmode != 'default') {
			$html .= '<param name="wmode" value="'.$wmode.'"';			
		}
	
 		$html .= '<param name="allowfullscreen" value="true" />
        		<param name="flashvars" value=\'config={"playlist":["'.$uri_image.$image.'", {"url": "'.$uri_flash.$flash.'",'.$autoplay_flash.','.$preload_flash.'}]}\' />
        		<img src="'.$image.'" width="'.$width.'" height="'.$height.'" alt="Poster Image" title="No video playback capabilities." />
      		</object>';
	}
	
	$html .= '</video>
			<p class="vjs-no-video"><strong>Download Video: </strong>';
	
	if ($video_mp4 != "0") {
		$html .= '<a href="'.$video_mp4.'">MP4</a>, ';
	}
	
	if ($video_webm != "0") {
		$html .= '<a href="'.$video_webm.'">WebM</a>, ';
	}
	
	if ($video_ogg != "0") {
		$html .= '<a href="'.$video_ogg.'">Ogg</a><br>';
	}

	$html .= '<a href="http://videojs.com">HTML5 Video Player</a> by VideoJS
			</p>
  		</div>';

	return $html;
	
}
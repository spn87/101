<?php

/**
* @package     Elexi Carousel
* @link        http://www.ecommercedevelopment.co.in
* @version     1.0.0
* @copyright   Copyright (C) 2010 dhavalramwani
* @license     GNU/GPL http://www.gnu.org/copyleft/gpl.html
*/
defined('_JEXEC') or die('Restricted access');

class modElexiCarouselHelper
{
	var $controlNavThumbsReplace;
	var $dirs;
	
	function render(& $params)
	{
		global $mainframe;
		$document = & JFactory :: getDocument();
		$URLOriginal = modElexiCarouselHelper :: getOverrideURL();
		$module_base = $URLOriginal . 'modules/mod_elexicarousel/assets/';

		JHTML :: script('jquery.min.js', $module_base);
		
		JHTML :: script('jquery.theatre-1.0.js', $module_base);
		JHTML :: script('jquery.fancybox-1.3.4.pack.js', $module_base);
		
	  	$document->addStyleSheet($module_base . 'theatre.css', 'text/css', 'screen');
		$document->addStyleSheet($module_base . 'jquery.fancybox-1.3.4.css', 'text/css', 'screen');
		
		$imagesDir = rtrim($params->get('imagesDir', 'images/banners/'), '/\\');
		$speed = $params->get('speed', '1000');
		
		
		$this->controlNavThumbsReplace = $params->get('controlNavThumbsReplace', '_thumb.jpg');
		
		$display = true;
		
?>
	
<?php
		
		$html = "<div id='demo' class='theatreDemo theatre theatre-3d' style='width: 632px; height:400px; margin: auto;'>";
		
		
		$imagesDir = array($imagesDir);

		$images = modElexiCarouselHelper :: getImages($imagesDir);
		if (!$images)
			return false;
		list($width, $height, $type, $attr) = getimagesize($images[0]);
		
		
		
		$i = 0;
		
		foreach ($images as $image)
		{
		
		
				$nimg = "<a href='$URLOriginal" . str_replace("%2F", "/", rawurlencode($images[$i])) . "' class='zoom;'>";
			$nimg .= "<img src='$URLOriginal" . str_replace("%2F", "/", rawurlencode($images[$i])) . "'";
			$nimg .= " />";
			if (isset($imgAtt[$i][2]))
				$nimg .= "</a>";
			$html .= $nimg . "\n";
			$i++;
		}
		$html .= '
		</div>
';
		if ($display == true)
			echo $html;
		else
			echo '&nbsp;';
	}

	
	function getImages($dir)
	{
		foreach ($dir as $i=>$k){


			foreach (array_merge(
				(array)glob("$k/*.jpg"),
				(array)glob("$k/*.png"),
				(array)glob("$k/*.gif")) as $filename)
			{
				if ($filename && !preg_match("/$this->controlNavThumbsReplace/", $filename))
					$files[] = $filename;
			}
		}
		return $files;
	}

	function getOverrideURL()
	{
		$pathURL = array();
		$uri = & JURI :: getInstance();
		$pathURL['prefix'] = $uri->toString(array('scheme', 'host', 'port'));
		$pathURL['path'] = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
		return $pathURL['prefix'] . $pathURL['path'] . '/';
	}

}
?>

<script type="text/javascript">
	$(function() {
	  $('#demo').theatre({
	    selector: 'img', // We want to resize/rotate images and not links
		effect: '3d',
		speed: '<?php echo $speed;?>'
	  });

	   $('#demo a').fancybox();
	});
  </script>
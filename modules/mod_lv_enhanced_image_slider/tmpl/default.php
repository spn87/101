<?php defined('_JEXEC') or die('Restricted access'); // no direct access

/**
 * LV ENHANCED image slider - An AJAX image slider
 *
 * @version 1.0
 * @package LV ENHANCED image slider
 * @author Juergen Koller
 * @copyright (C) http://www.lernvid.com
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/


	// set width of nav	
	$lveisnav_width = $lveisWidth - 10;

	// math the height if nav active	
	if ($useNav == 1) {
		$lveis_height = $ulHeight + $navHeight; 
	}
	else {
		$lveis_height = $ulHeight; 
	};			

	// slider background color
	if ($transparentBgColor == 1) {
		$sliderBg = 'transparent';
	}
	else {
		$sliderBg = '#'.$lveis_bgcolor;
	};			


// get the document object
$doc =& JFactory::getDocument();

// style declaration
$doc->addStyleDeclaration( '
#lveis-wrapper_'.$slider_id.' {
	width: '.$lveisWidth.'px !important;
	height: '.$lveis_height.'px !important;
	background-color: '.$sliderBg.' !important;
	margin:0 0 10px 0 !important;
	padding:0 !important;
	float:'.$lveisFloat.';
}
#lveis-wrapper_'.$slider_id.' ul#lveis {
	height: '.$ulHeight.'px !important;
}
#lveis-wrapper_'.$slider_id.' ul#lveis, #lveis-wrapper_'.$slider_id.' ul#lveis li {
	margin:0;
	padding:0;
	list-style-type:none;
	overflow:hidden;
}
#lveis-wrapper_'.$slider_id.' .lveisnav {
	width: '.$lveisnav_width.'px !important;
	height: '.$navHeight.'px !important;
	background:#'.$lveisnav_bgcolor.' !important;
	border:1px solid #'.$lveisnav_bordercolor.' !important;
	padding:4px !important;
	display:inline-block;
	display:block;
	overflow: hidden;
}
#lveis-wrapper_'.$slider_id.' .lveisindex a {
	float:left;
	background-image:url("modules/mod_lv_enhanced_image_slider/images/links.png");
	background-repeat:no-repeat;
}
#lveis-wrapper_'.$slider_id.' .lveisindex a:hover {
	background-image:url("modules/mod_lv_enhanced_image_slider/images/links.png");
	background-repeat:no-repeat;
	background-position: 0 -26px;
}
#lveis-wrapper_'.$slider_id.' .lveisnav .prev, #lveis-wrapper_'.$slider_id.' .lveisnav .next {
	float:right;
	display:block;
}
#lveis-wrapper_'.$slider_id.' .lveisnav a {
	color:#'.$lveisnav_a.' !important;
	border:1px solid #'.$lveisnav_aborder.' !important;
	font-family: Arial, Helvetica, Sans-Serif !important;
	font-size:14px !important;
	padding:0 3px !important;
	margin:2px;
	text-decoration:none;
}
#lveis-wrapper_'.$slider_id.' .lveisnav a:hover {
	color: #'.$lveisnav_ahover.' !important;
}
#lveis-wrapper_'.$slider_id.' .lveisindex a.activeSlide {
	color: #'.$lveisnav_aact.' !important;
	background:#'.$lveisnav_aactbg.' !important;
	border-color:#'.$lveisnav_aactborder.' !important;
	font-weight:bold;
}
#lveis-wrapper_'.$slider_id.' #lveis img, #lveis-wrapper_'.$slider_id.' #lveis a {
	border:0 !important;
	outline:0 !important;
	margin:0 !important;
	padding:0 !important;
}
#lveis-wrapper_'.$slider_id.' .lveisnav-clr {
	clear:both;
}
'  );
?>


<?php if ($useCompression == 0) {?>
	<script type="text/javascript" src="modules/mod_lv_enhanced_image_slider/js/jquery-1.4.4.min.js"></script>
	<script type="text/javascript" src="modules/mod_lv_enhanced_image_slider/js/jquery.cycle.all.min.js"></script>
<?php }; ?>
<?php if ($useCompression == 1) {?>
	<script type="text/javascript" src="modules/mod_lv_enhanced_image_slider/js/js_compress.php"></script>
<?php }; ?>

<script type="text/javascript"> 
	var jQlveis = jQuery.noConflict(); 
	jQlveis(document).ready(function() {
		jQlveis('#lveis-wrapper_<?php echo $slider_id; ?> ul#lveis').cycle({
			fx: '<?php echo $effectFx; ?>',
			random: <?php echo $random; ?>,
			timeout: <?php echo $timeout; ?>,
			speed: <?php echo $speed; ?>,
			next: '#lveis-wrapper_<?php echo $slider_id; ?> .lveisnav .next',
			prev: '#lveis-wrapper_<?php echo $slider_id; ?> .lveisnav .prev',
			pager:'#lveis-wrapper_<?php echo $slider_id; ?> .lveisindex',
			height: <?php echo $ulHeight; ?>,
			pause: <?php echo $pause; ?>
		});
	});
</script>
<?php if ($imageCentered == 1) {echo'<center>';}; ?>
	<noscript>You need Javascript enabled in your browser to see sliding images...</noscript>
	<?php if ($useModalbox == 1) {
		JHTML::_('behavior.mootools');
		JHTML::_('behavior.modal');
	};?>

	<div id="lveis-wrapper_<?php echo $slider_id; ?>">
		<ul id="lveis">
			<?php 
				$files = glob($imageFolder . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE); 
				for ($i=0; $i<count($files); $i++) 
				{ 
					$num = $files[$i];
					echo '<li>';
					if ($uselinks == 1) {
						if ($stretchImages == 1) {
							echo '<a class="modal" href="'.$num.'" target="'.$linktarget.'"><img src="'.$num.'" alt="'.$num.'" width="'.$imageWidth.'" height="'.$imageHeight.'" /></a>';
						}
						else {
	
							echo '<a class="modal" href="'.$num.'" target="'.$linktarget.'"><img src="'.$num.'" alt="'.$num.'" /></a>';
						};
					}
					else {
						if ($stretchImages == 1) {
							echo '<img src="'.$num.'" alt="'.$num.'" width="'.$imageWidth.'" height="'.$imageHeight.'" />';
						}
						else {
							echo '<img src="'.$num.'" alt="'.$num.'" />';
						};
					};			
					echo'</li>'; 
				} 
			?>
		</ul>
		<?php if ($useNav == 1) {?>
			<div class="lveisnav">
				<?php if ($nextbutton == 1) {?>
					<a href="javascript:void(0);" class="next">Next</a>
				<?php }; ?>
				<?php if ($prevbutton == 1) {?>
					<a href="javascript:void(0);" class="prev">Prev</a>
				<?php }; ?>
				<?php if ($lveisindex == 1) {?>
					<div class="lveisindex"></div>
				<?php }; ?>
			</div>
		<?php }; ?>
		<div class="lveisnav-clr"></div>
	</div>
<?php if ($imageCentered == 1) {echo'</center>';}; ?>

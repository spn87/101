<?php
/*
 * @package Easy Slider Pro for Joomla! 1.5
 * @version $Id: 1.0.5
 * @author Turnkeye.com
 * @copyright (C) 2010 Turnkeye.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

// no direct access
defined('_JEXEC') or die('Restricted access');

//configuration parameters
$speed = $params->get( 'speed', '800' );

$numeric = $params->get( 'numeric', '' );
$navigation = $numeric == 'show' ? 'true' : 'false';

$continuous = $params->get( 'continuous', '' );
$wcontinuous = $continuous == 'show' ? 'true' : 'false';

$auto = $params->get( 'auto', '' );
$wauto = $auto == 'show' ? 'true' : 'false';

$hide_load = $params->get( 'hide_load', '' );
$delay_first = $params->get( 'delay_first', '0' );

$demo = $params->get( 'demo', '' );
$imagesfolder = $params->get( 'imagesfolder', '' );
$imagesnames = $params->get( 'imagesnames', '' );
$imagecaptions = $params->get( 'imagecaptions', '' );
$imagelinks = $params->get( 'imagelinks', '' );

$bback = $params->get( 'bback', '' );
$sback = $params->get( 'sback', '' );
$bcolor = $params->get( 'bcolor', '' );
$scolor = $params->get( 'scolor', '' );

$width = $params->get( 'width', '' ).'px';
$width = $width > 0 ? $width : '490px';

$height = $params->get( 'height', '' ).'px';
$height = $height > 0 ? $height : '241px';

$images = $params->get( 'images', '' );

$joomla_path = JURI::root();

//load CSS
$document = JFactory::getDocument();
$document->addStyleSheet($joomla_path.'/modules/mod_easy_slider/css/style.css');

$css_code = "
    #container{
        width:$width;
    }
    #slider li, #slider2 li{
        width:$width;
        height:$height;
    }
    #nextBtn, #slider1next{
        left:$width;
    }
    #prevBtn a, #nextBtn a, #slider1next a, #slider1prev a{
        background:$joomla_path/modules/mod_easy_slider/css/btn_prev.gif) no-repeat 0 0;
    }
    #nextBtn a, #slider1next a{
        background:url($joomla_path/modules/mod_easy_slider/css/btn_next.gif) no-repeat 0 0;
    }
    ol#controls li a{
        background:$bback;
        color:$bcolor;
    }
    ol#controls li.current a{
        background:$sback;
        color:$scolor;
    }";
$document->addStyleDeclaration($css_code);

if ($demo == "show"){
    $wcontent = '<li><a href="http://www.example.com"><img src="modules/mod_easy_slider/01.jpg" alt="Image 1" /></a></li>
	<li class = "hide_slide"><a href="http://www.example.com"><img src="modules/mod_easy_slider/02.jpg" alt="Image 2" /></a></li>
	<li class = "hide_slide"><a href="http://www.example.com"><img src="modules/mod_easy_slider/03.jpg" alt="Image 3" /></a></li>
	<li class = "hide_slide"><a href="http://www.example.com"><img src="modules/mod_easy_slider/04.jpg" alt="Image 4" /></a></li>
	<li class = "hide_slide"><a href="http://www.example.com"><img src="modules/mod_easy_slider/05.jpg" alt="Image 5" /></a></li>';
} else {

    function func_easyslider_txt_to_array($text) {
	//special chars to be removed
	$invalid_array_chars = array("\n");

	if ($text) {
	    $_text = str_replace($invalid_array_chars, "", $text);
		if ($_text) {
		    $_arr = explode(",", $_text);
		    if ($_arr)
			$_arr = array_map("trim", $_arr);
		    return (! empty($_arr) ? $_arr: false);
		}
	}

	return false;
    }

    // get images array
    $imgs = func_easyslider_txt_to_array($imagesnames);

    // get images ALTs
    $caps = func_easyslider_txt_to_array($imagecaptions);

    //get images links
    $links = func_easyslider_txt_to_array($imagelinks);

    $i = 0;
    $wcontent = "";
    $class = "";    

    // construct images content
    if ($imgs) {
	foreach ($imgs as $imgs_item) {
	    if ($i >0) $class = " class = 'hide_slide'";
	    $wcontent = $wcontent."<li $class><a href='".$links[$i]."'><img src='".$imagesfolder.$imgs_item."' alt='".$caps[$i]."' /></a></li>";
	    $i++;
	}
    }
}
?>

<div class="easy_slider_module">
    <script type="text/javascript" src="modules/mod_easy_slider/jquery.js"></script>
    <script type="text/javascript" src="modules/mod_easy_slider/easySlider.js"></script>
    <script type="text/javascript">
	jQuery.noConflict();

	function easyslider() {
	    jQuery("#slider ul li").removeClass("hide_slide");
            jQuery("#slider").easySlider({
                auto: <?php echo $wauto ?>,
                continuous: <?php echo $wcontinuous ?>,
                speed: <?php echo $speed ?>,
                numeric: <?php echo $navigation ?>
            });
	}
		
	<?php  if ($hide_load == "show") :?>
	jQuery(window).load(function(){
	    jQuery("#slider").show();
	<?php else: ?>
        jQuery(document).ready(function(){
	<?php endif; ?>
		setTimeout('easyslider()', <?php echo $delay_first; ?>);
	});
    </script>

    <div id="container">
	<div id="content">
	    <div id="slider" <?php  if ($hide_load == "show") :?>style="display:none;"<?php endif; ?>>
		<ul>
		    <?php echo $wcontent; ?>
		</ul>
	    </div>
	</div>
    </div>

</div>
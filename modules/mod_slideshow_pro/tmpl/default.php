<?php 
/**
* @version		$Id: default.php 00005 2009-11-10 00:00:00 umitkenan $
* @package		Joomla
* @subpackage	SlideShow Pro Module
* @link 		http://www.jt.gen.tr
* @copyright	Copyright (C) Joomla Türkçe Eğitim ve Destek Sitesi. http://www.jt.gen.tr 
* @license		GNU/GPL
* @information  Based on jQuery jCarouselLite Plugin
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
?>

<script type="text/javascript">
/* <![CDATA[ */
// Main codes
jQuery(document).ready(function(){
	jQuery(".<?php echo $this->boxname; ?>").jCarouselLite({
		auto: <?php echo $this->delay; ?>,
		speed: <?php echo $this->speed; ?>,
		visible: <?php echo $this->visible; ?>,
		<?php echo $this->easing; ?>
		<?php echo $this->layout; ?>
		<?php echo $this->hoverPause; ?>
	});	
});
/* ]]> */
</script>

<div class="JT-ClearBox"></div>

<div id="<?php echo $this->boxname; ?>wrapper">
 <div class="<?php echo $this->boxname; ?>"><ul><?php for ( $i=0 ; $i < count($this->image) ; $i++ ) echo $this->slideshowcontent[$i]; ?></ul></div>
</div>
	
<div class="JT-ClearBox"></div>

<?php echo $this->slideshowprofooter; ?>

<script type="text/javascript">jQuery.noConflict();</script>
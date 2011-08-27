<?php
/**
* YOOslider Joomla! Module
*
* @version   1.5.0
* @author    yootheme.com
* @copyright Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
* @license	 GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="yoo-slider <?php echo $container_class ?>" style="<?php echo $container_style ?>">
	<ul id="<?php echo $slider_id ?>" class="yoo-sliderlist">
	<?php for ($i=0; $i < $items; $i++) : ?>
		<?php
			$listitem = $list[$i];
			$item_class = "item";
			if ($i == 0) $item_class .= " first";
			if ($i == 0 && $mode == 'drawer') $item_class .= " active";
			if ($i == $items - 1) $item_class .= " last";
			if ($mode == 'drawer') {
				$item_style = "position: absolute; $item_pos: " . ($item_minimized * $i) . "px; z-index: " . ($items - $i) . ";";
				($layout == 'vertical') ? $item_style .= " width: 100%;" : $item_style .= "";
			}
		?>
		
		<?php if ($layout == 'vertical') :  ?>
		<li class="<?php echo $item_class ?>" style="<?php echo $item_style ?>">
			<div class="item-bl">
				<div class="item-br">
					<div class="item-b">
						<div class="item-l">
							<div class="item-r" style="<?php echo 'height: ' . ($item_size - 10) . 'px;' ?>">
								<?php modYOOsliderHelper::renderItem($listitem, $params, $access); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</li>
		<?php endif; ?>
		
		<?php if ($layout == 'horizontal') :  ?>
		<li class="<?php echo $item_class ?>" style="<?php echo $item_style ?>">
			<div class="item-r" style="<?php echo 'height: ' . ($module_height - 5) . 'px;' ?>">
				<div class="toggler" style="<?php echo 'overflow: hidden; width: ' . $item_size . 'px;' ?>">
					<?php modYOOsliderHelper::renderItem($listitem, $params, $access); ?>
				</div>
			</div>
		</li>
		<?php endif; ?>
		
	<?php endfor; ?>
	</ul>
</div>
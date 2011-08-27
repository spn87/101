<style>
	.title{color:#00F;width:200px;font-size:14px}
	.col{background:#CF6;}
</style>


<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>


<div class="contentpaneopen<?php echo $this->escape($this->item->params->get( 'pageclass_sfx' )); ?>">

<?php if ($this->item->params->get('show_title')) : ?>
<h2 class="contentheading<?php echo $this->escape($this->item->params->get( 'pageclass_sfx' )); ?>">
	<?php if ($this->item->params->get('link_titles') && $this->item->readmore_link != '') : ?>
	<a href="<?php echo $this->item->readmore_link; ?>" class="contentpagetitle<?php echo $this->escape($this->item->params->get( 'pageclass_sfx' )); ?>">
		<?php echo "<div class='title col'>".$this->escape($this->item->title)."</div>";; ?>
	</a>
	<?php else : ?>
		<?php echo "<div class='title col'>".$this->escape($this->item->title)."</div>"; ?>
	<?php endif; ?>
 	 
</h2>
<?php endif; ?>

<?php  if (!$this->item->params->get('show_intro')) :
	echo $this->item->event->afterDisplayTitle;
endif; ?>



<?php echo $this->item->event->beforeDisplayContent; ?>

<div class="article-content">
<?php if (isset ($this->item->toc)) : ?>
	<?php echo $this->item->toc; ?>
<?php endif; ?>
<?php echo $this->item->text; ?>
</div>



<?php if ($this->item->params->get('show_readmore') && $this->item->readmore) : ?>
	<a href="<?php echo $this->item->readmore_link; ?>" title="<?php echo $this->escape($this->item->title); ?>" class="readon<?php echo $this->escape($this->item->params->get('pageclass_sfx')); ?>">
			<?php
				if ($this->item->readmore_register) :
					echo JText::_('Register to read more...');
				elseif ($readmore = $this->item->params->get('readmore')) :
					echo $readmore ;
				else :
					echo "<div align='right' class='col'  style='color:blue;'>".JText::sprintf('Read more...')."</div>";
				endif;
			?>
	</a>
<?php endif; ?>

<?php $ids=$this->item->id; ?>

	<a  class="readon<?php echo $this->escape($this->item->params->get('pageclass_sfx')); ?>">
		<?php
			echo "<div align='right' class='col' id='cusbooking$ids' style='font:bold;color:#00C;font-size:10px;font-weight:100'> Booking....... </div>";
			
			?>
	</a>



</div>
<span class="article_separator" >&nbsp;</span>


<div style="margin-top:-20px;">
<?php if ($this->item->sectionid == 2):?>
	<?php $ids=$this->item->id; ?>
	

<!--==========================================================================-->

<div id='booking<?php echo $ids ?>' style='width:400px;padding:10px 10px 10px 10px; border:#999 solid 1px;'>
<table>
<tr>
<td>
<td>

<div class="col" style="font-size:12px;color:#03C;" align="center">

<?php if ($this->item->params->get('show_title')) : ?>

	<?php if ($this->item->params->get('link_titles') && $this->item->readmore_link != '') : ?>
	<a href="<?php echo $this->item->readmore_link; ?>" class="contentpagetitle<?php echo $this->escape($this->item->params->get( 'pageclass_sfx' )); ?>">
		<?php echo $this->escape($this->item->title); ?>
	</a>
	<?php else : ?>
		<?php echo $this->escape($this->item->title); ?>
	<?php endif; ?>
<?php endif; ?>
</div>
</td>
</td>
<td></td>
</tr>
<tr>
<td>Name</td>
<td><input type="text" name="cusname" size="40px" /></td>
</tr>
<tr>
<td>E-mail</td>
<td><input type="text" name="cusemail" size="40px" /></td>
</tr>
<tr>
<td>Detail</td>
<td><textarea cols="60" rows="8"  name="cusdetail"></textarea></td>
</tr>
<tr>
<td></td>
<td><input type="submit" value="Booking" name="cussave" /></td>
</tr>
  </table>
</div>

<script>
$('#cusbooking<?php echo $ids ?>').click(function() {
  $('#booking<?php echo $ids ?>').slideToggle('slow', function() {
    $('#book<?php echo $ids ?>').slideUp('fast', function() {});
  });
});
$('#booking<?php echo $ids ?>').slideUp('fast', function() {});
</script>


<br />
<div style="border-bottom:solid #999 1px;"></div>
<?php endif;?>



</div>

<?php echo $this->article->text; ?>


<?php echo $this->item->event->afterDisplayContent; ?>

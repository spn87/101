<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php if ($this->params->get('show_page_title', 1) && $this->params->get('page_title') != $this->article->title) : ?>
<div class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>"><?php echo $this->escape($this->params->get('page_title')); ?></div>
<?php endif; ?>
<?php if (($this->user->authorize('com_content', 'edit', 'content', 'all') || $this->user->authorize('com_content', 'edit', 'content', 'own')) && !$this->print) : ?>
	<div class="contentpaneopen_edit<?php echo $this->escape($this->params->get( 'pageclass_sfx' )); ?>" >
		<?php echo JHTML::_('icon.edit', $this->article, $this->params, $this->access); ?>
	</div>
<?php endif; ?>

<?php if ($this->params->get('show_title',1)) : ?>
<h2 class="contentheading<?php echo $this->escape($this->params->get( 'pageclass_sfx' )); ?>">
	<?php if ($this->params->get('link_titles') && $this->article->readmore_link != '') : ?>
	<a href="<?php echo $this->article->readmore_link; ?>" class="contentpagetitle<?php echo $this->escape($this->params->get( 'pageclass_sfx' )); ?>">
		<?php echo $this->escape($this->article->title); ?>
	</a>
	<?php else : ?>
		<?php echo $this->escape($this->article->title); ?>
	<?php endif; ?>
</h2>
<?php endif; ?>

<?php  if (!$this->params->get('show_intro')) :
	echo $this->article->event->afterDisplayTitle;
endif; ?>



<?php echo $this->article->event->beforeDisplayContent; ?>

<div class="article-content">
<?php if (isset ($this->article->toc)) : ?>
	<?php echo $this->article->toc; ?>
<?php endif; ?>
<?php echo $this->article->text; ?>

</div>


<?php if ( intval($this->article->modified) !=0 && $this->params->get('show_modify_date')) : ?>
	<span class="modifydate">
		<?php echo JText::sprintf('LAST_UPDATED2', $this->escape(JHTML::_('date', $this->article->modified, JText::_('DATE_FORMAT_LC2')))); ?>
	</span>
<?php endif; ?>



<span class="article_separator">&nbsp;</span>

<div style="margin-top:-20px;">
<?php if ($this->item->sectionid == 2):?>
	<?php 
		$ids=$this->item->id;
echo "<a href='index.php?option=com_ttbooking&view=ttbooking&id=$ids'>
<img src='images/stories/Booking.gif'  width='80' height='30' /></a><hr />";
	
	?>
<?php endif;?>

<?php echo $this->article->text; ?>

<?php echo $this->article->event->afterDisplayContent; ?>

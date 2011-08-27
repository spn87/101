<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<div class="jx_latest_commented<?php echo $p->cls_div; ?>">
<?php echo $p->pretext; ?>
<?php if ( !empty( $comments ) ) { ?>
    <ul class="jxlc_list<?php echo $p->cls_list; ?>">
    <?php foreach ($comments as $row) { ?>
        <li class="jxlc_listitem<?php echo $p->cls_listitem; ?>">
            <?php echo $p->preitem; ?>
            <a href="<?php echo $row->itemlink; ?>" class="jxlc_link<?php echo $p->cls_link; ?>" <? echo $p->linktarget;?>><?php echo $row->title; ?></a>
            <?php if ( $p->showcomments ) { ?>
                <span class="jxlc_comments<?php echo $p->cls_commentcount; ?>">
                    (<?php echo $row->commentcount; ?> <?php echo $p->lang_comments; ?>)
                </span>
            <?php } ?>
            <?php if ( $p->showdate ) { ?>
                <span class="jxlc_date<?php echo $p->cls_date; ?>">
                    <?php echo ($p->showdate == 'commentdate') ? $row->commentdate : $row->contentdate; ?>
                </span>
            <?php } ?>
            <?php if ( $p->showcomment && !empty($row->comment)) { ?>
                <span class="jxlc_comment<?php echo $p->cls_comment; ?>">
                    <?php echo $row->comment; ?>
                </span>
            <?php } ?>
            <?php echo $p->postitem; ?>
        </li>
    <?php } ?>
    </ul>
<?php } else { ?>
    <span class="jxlc_nocomments<?php echo $p->cls_nocoments; ?>">
    <?php echo JText::_('No comments found.'); ?>
    </span>
<?php } ?>
<?php echo $p->posttext; ?>

<p class="jxlc_copyright">
<strong>Jx Latest Commented v2.0<br />
&copy; 2010 <a href='http://www.jxdevelopment.com/'>Olle Johansson</a></strong>
</p>
</div>

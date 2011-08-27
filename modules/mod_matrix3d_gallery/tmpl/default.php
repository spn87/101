<?php // no direct access

defined('_JEXEC') or die('Restricted access'); ?>

<?php
	
$i = 0;
$numr=count($images);

$texto='cantidad='.$numr.'&carpeta='.$params->get('folder').'&row='.$params->get('row').'&colorbordes='.$params->get('colorbordes').'&colortextos='.$params->get('colortextos').'&vertical='.$params->get('vertical').'&zoom1='.$params->get('zoom1').'&zoom2='.$params->get('zoom2').'&target='.$params->get('target').'&onlink='.$params->get('onlink').'&speed='.$params->get('speed').'&mouseover='.$params->get('mouseover').'&alpha='.$params->get('alpha').'&menu1='.$params->get('menu1').'&menu2='.$params->get('menu2').'&menu3='.$params->get('menu3').'&menu4='.$params->get('menu4').'&menu5='.$params->get('menu5').'&menu6='.$params->get('menu6').'&menu7='.$params->get('menu7');
$links=split("\n", $params->get('menulinks'));

$link1=str_replace("&", "a1s2t3eriso", $params->get('imagesc'));
$imagesc=split("\n", $link1);
$conta=0;

sort($images);
			foreach ($images as $img)
			{

					$auxilink="";
					$auxititle="";
					if(isset($links[$conta])) $auxititle=$links[$conta];
					if(isset($imagesc[$conta])) $auxilink=$imagesc[$conta];
					
					
					if ($params->get('onlink')=="1") {
						$texto.='&imagen'.$conta.'='.JURI::base().$params->get('folder').''.$img->name.'&title'.$conta.'='.$auxititle.'&link'.$conta.'='.$auxilink;
					}
					else{
					$texto.='&imagen'.$conta.'='.JURI::base().$params->get('folder').''.$img->name.'&title'.$conta.'='.$auxititle.'&link'.$conta.'='.$params->get('folder').$img->name;
					
					echo '<a href="'.JURI::base().$params->get('folder').''.$img->name.'" rel="shadowbox['.$nombrebox.']"></a>';
					
					
					
					}
				
					$conta++;

			}


?>






		<style type="text/css">

			.movie<?php echo $module->id; ?> {
				width: <?php echo $params->get('width'); ?>;
				height: <?php echo $params->get('height'); ?>;
				<?php if($params->get('background')!="") echo 'background-color: #'.$params->get('background'); ?>
				<?php if($params->get('imageb')!="") echo 'background-image: url('.$params->get('imageb').');'; ?>
			}
			div.movie<?php echo $module->id; ?> {
				width: <?php echo $params->get('width'); ?>;
				height: <?php echo $params->get('height'); ?>;
				
				border: <?php echo $params->get('border'); ?>px solid #<?php echo $params->get('bordercolor'); ?>;

			}
		</style>


<div class="movie<?php echo $module->id; ?>">


        		<div id="flashcontent<?php echo $module->id; ?>">
			Flash 8 required 
		</div>
<script type="text/javascript">
			var so = new SWFObject("<?php echo JURI::base(); echo 'modules/mod_matrix3d_gallery/tmpl/'; ?>mod_flash_rotator.swf", "bramfusion", "<?php echo $params->get('width'); ?>", "<?php echo $params->get('height'); ?>", "8", "#FFFFFF");
			so.addParam("quality", "high");
			so.addParam("wmode", "transparent");
			so.addParam("flashvars", "<?php
	
	echo $texto;
	
	
	?>");
			so.addParam("allowScriptAccess", "always");
			so.write("flashcontent<?php echo $module->id; ?>");
		</script>

</div>
<br/>
MATRIX 3D, test module.<br/>
<a href="http://www.webpsilon.com/joomla-extensions/index.php?option=com_content&view=article&id=4&Itemid=3">CLICK TO DOWNLOAD REAL VERSION.</a>
www.webpsilon.com/joomla-extensions
<br/>
<?php
/****************************************************
#####################################################
##-------------------------------------------------##
##           COMENIAN - Version 1.6.0              ##
##-------------------------------------------------##
## Copyright = globbersthemes.com- 2011            ##
## Date      = MARS 2011                           ##                     
## Author    = globbers                            ##
## Websites  = http://www.globbersthemes.com       ##
##                                                 ##
#####################################################
****************************************************/

// no direct access
defined('_JEXEC') or die('Restricted access');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo _LANGUAGE; ?>" xml:lang="<?php echo _LANGUAGE; ?>">

<head>
	<jdoc:include type="head" />
	<?php JHTML::_('behavior.framework', true); 
	$app                = JFactory::getApplication();
	$templateparams     = $app->getTemplate(true)->params;
	$csite_name	= $app->getCfg('sitename');
	$license = 'globbersthemes.com';
	?>
	
	<?php //setting slide fading
    $pause= $this->params->get("pause", "5");
    $fadespeed= $this->params->get("fadespeed", "0.5");
    $hauteur= $this->params->get("hauteur", "469");
    $largeur= $this->params->get("largeur", "950");
    ?>
	
	<?php //main width
    $mod_right = $this->countModules( 'position-7' );
    if ( $mod_right ) { $width = '';
    } else { $width = '-full';
    }
    ?>



<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/comenian1.6/css/tdefaut.css" type="text/css" media="all" />
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/mootools.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/scroll.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/jquery.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/slideshow.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/script.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->template ?>/js/DD_roundies_0.0.2a-min.js"></script>


<script type="text/javascript">
DD_roundies.addRule('#navigation ul li ul,.readmore a', '10px', true);
</script>

 <script type="text/javascript">
        window.addEvent('domready', function() {
        SqueezeBox.initialize({});
        $$('a.modal').each(function(el) {
            el.addEvent('click', function(e) {
                new Event(e).stop();
                 SqueezeBox.fromElement(el);
            });
         });
      });
    </script>
    
</head>
<body>
    <div id="top-header">
        <div class="pagewidth">
		    <div id="head">
		        <div id="sitename">
                    <a href="index.php"><img src="templates/<?php echo $this->template ?>/images/logo.png" width="233" height="79" alt="logotype" /></a>
			    </div>
				    <div id="search">
	                    <jdoc:include type="modules" name="position-0" />
                    </div>
			</div>
			    <div id="head-sub">
					    <div id="navigation">
                            <jdoc:include type="modules" name="position-3" />
			            </div>
						    <div id="loginbt">
                                <div  class="text-login">	<a href="#helpdiv" class="modal"  style="cursor:pointer" title="Login"  rel="{size: {x: 206, y: 333}, ajaxOptions: {method: &quot;get&quot;}}">
                                    <img src="templates/<?php echo $this->template ?>/images/login.jpg" width="62" height="31" alt="login form" /></a>
					            </div>
                            </div>
                                <div style="display:none;">
                                    <div id="helpdiv" >
                                        <jdoc:include type="modules" name="login" style="xhtml" />
                                    </div>
                                </div>
			</div>
		</div>
		<div class="pagewidth">
		    <div id="slideshow-w">
			    <div id="slideshow">
				    <img src="templates/<?php echo $this->template ?>/images/slide1.jpg" alt="image1" />
					<img src="templates/<?php echo $this->template ?>/images/slide2.jpg" alt="image2" />
					 <img src="templates/<?php echo $this->template ?>/images/slide3.jpg" alt="image3" />
				</div>
			</div>
				<script type="text/javascript" charset="utf-8">
					var $j = jQuery.noConflict(); 
						$j(document).ready(function(){
						 $j("#slideshow").slideshow({
			                pauseSeconds:<?php echo $pause ?>,// 5,
			                height:<?php echo $hauteur ?>, //469,
						    fadeSpeed:<?php echo $fadespeed ?>,// 0.5,
							width:<?php echo $largeur ?>, //950,
			                caption: false
		                });
		             });
				 </script>
						    
	    </div>
		    <div id="content-top">
			</div>
			    <div id="content">
				    <div class="pagewidth">
				        <div id="main<?php echo $width; ?>">
						    <jdoc:include type="component" />
						</div>
						<?php if($this->countModules('position-7')) : ?>
							<div id="right">
	                            <jdoc:include type="modules" name="position-7" style="xhtml" />
	                        </div>					
	                    <?php endif; ?>
					</div>
					    <div id="content-bottom">
			        </div>
					    <div id="footer-top">
					    </div>
					        <div id="footer">
		                        <div class="pagewidth">
			                        <div id="users-box">
				                        <div class="box">
						                    <jdoc:include type="modules" name="position-2" style="xhtml" />
					                    </div>
					        
					                    <div class="box">
						                    <jdoc:include type="modules" name="position-4" style="xhtml" />
					                    </div>
					        
					                    <div class="box">
						                    <jdoc:include type="modules" name="position-5" style="xhtml" />
					                    </div>
						
						                <div class="box">
						                    <jdoc:include type="modules" name="position-6" style="xhtml" />
					                    </div>
				                    </div>
			                    </div>
                            </div>
							    <div id="footer-bottom">
				                    <div class="pagewidth">
			                            <div class="ftb">
                                            Copyright&copy; <?php echo date( '2008 - Y' ); ?><?php echo $csite_name; ?>  .&nbsp;design by globbers for <a target=" _blank"  href= "http://www.globbersthemes.com" ><?php echo $license; ?> </a>
                                         </div>
                                            <div id="top">
                                                <div class="top_button">
                                                    <a href="#" onclick="scrollToTop();return false;">
						                            <img src="templates/<?php echo $this->template ?>/images/top.png" width="30" height="30" alt="top" /></a>
                                                </div>
					                        </div>
			                        </div>
				                </div>
			        
    

</body>
</html>
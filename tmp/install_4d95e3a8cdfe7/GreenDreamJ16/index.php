<?php /**  * @copyright	Copyright (C) 2011 JoomlaThemes.co - All Rights Reserved. **/
defined( '_JEXEC' ) or die( 'Restricted access' );
define( 'YOURBASEPATH', dirname(__FILE__) );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />
<?php require(YOURBASEPATH . DS . "functions.php"); ?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/styles.css" type="text/css" />

</head>

<body class="background">
<div id="main">
<div id="header-w">
    	<div id="header">
        	<?php if ($this->countModules('logo')) : ?>
                <div class="logo">
                	<jdoc:include type="modules" name="logo" style="none" />
                </div>
            <?php else : ?>        
            	<a href="<?php echo $this->baseurl ?>/">
				<img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/logo.png" border="0" class="logo">
				</a>
            <?php endif; ?>
		<div class="tguser">
		<jdoc:include type="modules" name="position-0" style="none" />
		</div>
            <?php if ($this->countModules('top')) : ?> 
                <div class="top">
                    <jdoc:include type="modules" name="top" style="none"/>
                </div>
            <?php endif; ?>                         
		</div>        
</div>
	<div id="wrapper">
        	
        	<div id="navr">
			<div id="navl">
			<div id="nav">
					<div id="nav-left">
					<jdoc:include type="modules" name="menu" style="none" /></div>
					<div id="nav-right"></div></div></div></div>
 		<div id="main-content">
        <?php if ($this->countModules('breadcrumb')) : ?>
        	<jdoc:include type="modules" name="breadcrumb"  style="none"/>
        <?php endif; ?>
		<div id="message">
		    <jdoc:include type="message" />
		</div>    
            <?php if($this->countModules('left')) : ?>
	<div id="leftbar-w">
    <div id="sidebar">
        <jdoc:include type="modules" name="left" style="jaw" /></div></div>
    <?php endif; ?>
    <?php if($this->countModules('left') xor $this->countModules('right')) $maincol_sufix = '_md';
		  elseif(!$this->countModules('left') and !$this->countModules('right'))$maincol_sufix = '_bg';
		  else $maincol_sufix = ''; ?>
	<div id="centercontent<?php echo $maincol_sufix; ?>">
    	<div class="clearpad"><jdoc:include type="component" /></div>
    </div>
    <?php if($this->countModules('right') and JRequest::getCmd('layout') != 'form') : ?>
	<div id="rightbar-w">
    <div id="sidebar">
         <jdoc:include type="modules" name="right" style="jaw" />
    </div>
    </div>
    <?php endif; ?>
	<div class="clr"></div>
        </div>   
		<div class="bot1"><div class="bot2"><div class="bot3"></div></div></div>		
        </div>     
  </div>
</div>
		<?php if ($this->countModules('user4 or user5 or user6')) : ?>
		<?php endif; ?>   
<?php if ($this->countModules('user7 or user8 or user9 or user10')) : ?>
<div id="footer">
	<div class="footer-pad">
    	<div class="top1"><div class="top2"><div class="top3"></div></div></div>
        <div class="bot1"><div class="bot2"><div class="bot3"></div></div></div> 
  </div>    
</div>        
<?php endif; ?>
<div id="bottom">
        <?php if ($this->countModules('copyright')) : ?>
            <div class="copy">
                <jdoc:include type="modules" name="copyright"/>
            </div>
        <?php endif; ?>
<div class="design">Design by <a href="http://www.themegoat.com">Joomla 1.6 templates</a></div>
</div>
</div>
</body>
</html>
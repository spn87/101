<?php
/**
@version 1.0: mod_S5_mediaplayer
Author: Shape 5 - Professional Template Community
Available for download at www.shape5.com
Copyright Shape 5 LLC
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$LiveSite = JURI::base();

$pretext		= $params->get( 'pretext', '' );
$height		    = $params->get( 'height', '' );
$width   		= $params->get( 'width', '' );
$lightdark		= $params->get( 'lightdark', '' );
$mpbgcolor	    = $params->get( 'mpbgcolor', '' );


$s5mp_ratio1   		= $params->get( 's5mp_ratio1', '' );
$s5mp_name1   		= $params->get( 's5mp_name1', '' );
$s5mp_description1	= $params->get( 's5mp_description1', '' );
$s5mp_movie1   		= $params->get( 's5mp_movie1', '' );
$s5mp_icon1   		= $params->get( 's5mp_icon1', '' );

$s5mp_ratio2   		= $params->get( 's5mp_ratio2', '' );
$s5mp_name2   		= $params->get( 's5mp_name2', '' );
$s5mp_description2	= $params->get( 's5mp_description2', '' );
$s5mp_movie2   		= $params->get( 's5mp_movie2', '' );
$s5mp_icon2   		= $params->get( 's5mp_icon2', '' );

$s5mp_ratio3   		= $params->get( 's5mp_ratio3', '' );
$s5mp_name3   		= $params->get( 's5mp_name3', '' );
$s5mp_description3	= $params->get( 's5mp_description3', '' );
$s5mp_movie3   		= $params->get( 's5mp_movie3', '' );
$s5mp_icon3   		= $params->get( 's5mp_icon3', '' );

$s5mp_ratio4   		= $params->get( 's5mp_ratio4', '' );
$s5mp_name4   		= $params->get( 's5mp_name4', '' );
$s5mp_description4	= $params->get( 's5mp_description4', '' );
$s5mp_movie4   		= $params->get( 's5mp_movie4', '' );
$s5mp_icon4   		= $params->get( 's5mp_icon4', '' );

$s5mp_ratio5   		= $params->get( 's5mp_ratio5', '' );
$s5mp_name5   		= $params->get( 's5mp_name5', '' );
$s5mp_description5	= $params->get( 's5mp_description5', '' );
$s5mp_movie5   		= $params->get( 's5mp_movie5', '' );
$s5mp_icon5   		= $params->get( 's5mp_icon5', '' );

$s5mp_ratio6   		= $params->get( 's6mp_ratio6', '' );
$s5mp_name6   		= $params->get( 's6mp_name6', '' );
$s5mp_description6	= $params->get( 's6mp_description6', '' );
$s5mp_movie6   		= $params->get( 's6mp_movie6', '' );
$s5mp_icon6   		= $params->get( 's6mp_icon6', '' );

$s5mp_ratio7   		= $params->get( 's5mp_ratio7', '' );
$s5mp_name7   		= $params->get( 's5mp_name7', '' );
$s5mp_description7	= $params->get( 's5mp_description7', '' );
$s5mp_movie7   		= $params->get( 's5mp_movie7', '' );
$s5mp_icon7   		= $params->get( 's5mp_icon7', '' );

$s5mp_ratio8   		= $params->get( 's5mp_ratio8', '' );
$s5mp_name8   		= $params->get( 's5mp_name8', '' );
$s5mp_description8	= $params->get( 's5mp_description8', '' );
$s5mp_movie8   		= $params->get( 's5mp_movie8', '' );
$s5mp_icon8   		= $params->get( 's5mp_icon8', '' );

$s5mp_ratio9   		= $params->get( 's5mp_ratio9', '' );
$s5mp_name9   		= $params->get( 's5mp_name9', '' );
$s5mp_description9	= $params->get( 's5mp_description9', '' );
$s5mp_movie9   		= $params->get( 's5mp_movie9', '' );
$s5mp_icon9   		= $params->get( 's5mp_icon9', '' );

$s5mp_ratio10   		= $params->get( 's5mp_ratio10', '' );
$s5mp_name10   		= $params->get( 's5mp_name10', '' );
$s5mp_description10	= $params->get( 's5mp_description10', '' );
$s5mp_movie10   		= $params->get( 's5mp_movie10', '' );
$s5mp_icon10   		= $params->get( 's5mp_icon10', '' );

$s5mp_ratio11   		= $params->get( 's5mp_ratio11', '' );
$s5mp_name11   		= $params->get( 's5mp_name11', '' );
$s5mp_description11	= $params->get( 's5mp_description11', '' );
$s5mp_movie11   		= $params->get( 's5mp_movie11', '' );
$s5mp_icon11   		= $params->get( 's5mp_icon11', '' );

$s5mp_ratio12   		= $params->get( 's5mp_ratio12', '' );
$s5mp_name12   		= $params->get( 's5mp_name12', '' );
$s5mp_description12	= $params->get( 's5mp_description12', '' );
$s5mp_movie12   		= $params->get( 's5mp_movie12', '' );
$s5mp_icon12   		= $params->get( 's5mp_icon12', '' );

$s5mp_ratio13   		= $params->get( 's5mp_ratio13', '' );
$s5mp_name13   		= $params->get( 's5mp_name13', '' );
$s5mp_description13	= $params->get( 's5mp_description13', '' );
$s5mp_movie13   		= $params->get( 's5mp_movie13', '' );
$s5mp_icon13   		= $params->get( 's5mp_icon13', '' );

$s5mp_ratio14   		= $params->get( 's5mp_ratio14', '' );
$s5mp_name14   		= $params->get( 's5mp_name14', '' );
$s5mp_description14	= $params->get( 's5mp_description14', '' );
$s5mp_movie14   		= $params->get( 's5mp_movie14', '' );
$s5mp_icon14   		= $params->get( 's5mp_icon14', '' );

$s5mp_ratio15   		= $params->get( 's5mp_ratio15', '' );
$s5mp_name15   		= $params->get( 's5mp_name15', '' );
$s5mp_description15	= $params->get( 's5mp_description15', '' );
$s5mp_movie15   		= $params->get( 's5mp_movie15', '' );
$s5mp_icon15   		= $params->get( 's5mp_icon15', '' );

$s5mp_ratio16   		= $params->get( 's5mp_ratio16', '' );
$s5mp_name16   		= $params->get( 's5mp_name16', '' );
$s5mp_description16	= $params->get( 's5mp_description16', '' );
$s5mp_movie16   		= $params->get( 's5mp_movie16', '' );
$s5mp_icon16   		= $params->get( 's5mp_icon16', '' );

$s5mp_ratio17   		= $params->get( 's5mp_ratio17', '' );
$s5mp_name17   		= $params->get( 's5mp_name17', '' );
$s5mp_description17	= $params->get( 's5mp_description17', '' );
$s5mp_movie17   		= $params->get( 's5mp_movie17', '' );
$s5mp_icon17   		= $params->get( 's5mp_icon17', '' );

$s5mp_ratio18   		= $params->get( 's5mp_ratio18', '' );
$s5mp_name18   		= $params->get( 's5mp_name18', '' );
$s5mp_description18	= $params->get( 's5mp_description18', '' );
$s5mp_movie18   		= $params->get( 's5mp_movie18', '' );
$s5mp_icon18   		= $params->get( 's5mp_icon18', '' );

$s5mp_ratio19   		= $params->get( 's5mp_ratio19', '' );
$s5mp_name19   		= $params->get( 's5mp_name19', '' );
$s5mp_description19	= $params->get( 's5mp_description19', '' );
$s5mp_movie19   		= $params->get( 's5mp_movie19', '' );
$s5mp_icon19   		= $params->get( 's5mp_icon19', '' );

$s5mp_ratio20   		= $params->get( 's5mp_ratio20', '' );
$s5mp_name20   		= $params->get( 's5mp_name20', '' );
$s5mp_description20	= $params->get( 's5mp_description20', '' );
$s5mp_movie20   		= $params->get( 's5mp_movie20', '' );
$s5mp_icon20   		= $params->get( 's5mp_icon20', '' );

$s5mp_ratio21   		= $params->get( 's5mp_ratio21', '' );
$s5mp_name21   		= $params->get( 's5mp_name21', '' );
$s5mp_description21	= $params->get( 's5mp_description21', '' );
$s5mp_movie21   		= $params->get( 's5mp_movie21', '' );
$s5mp_icon21   		= $params->get( 's5mp_icon21', '' );

$s5mp_ratio22   		= $params->get( 's5mp_ratio22', '' );
$s5mp_name22   		= $params->get( 's5mp_name22', '' );
$s5mp_description22	= $params->get( 's5mp_description22', '' );
$s5mp_movie22   		= $params->get( 's5mp_movie22', '' );
$s5mp_icon22   		= $params->get( 's5mp_icon22', '' );

$s5mp_ratio23   		= $params->get( 's5mp_ratio23', '' );
$s5mp_name23   		= $params->get( 's5mp_name23', '' );
$s5mp_description23	= $params->get( 's5mp_description23', '' );
$s5mp_movie23   		= $params->get( 's5mp_movie23', '' );
$s5mp_icon23   		= $params->get( 's5mp_icon23', '' );

$s5mp_ratio24   		= $params->get( 's5mp_ratio24', '' );
$s5mp_name24   		= $params->get( 's5mp_name24', '' );
$s5mp_description24	= $params->get( 's5mp_description24', '' );
$s5mp_movie24   		= $params->get( 's5mp_movie24', '' );
$s5mp_icon24   		= $params->get( 's5mp_icon24', '' );

$s5mp_ratio25   		= $params->get( 's5mp_ratio25', '' );
$s5mp_name25   		= $params->get( 's5mp_name25', '' );
$s5mp_description25	= $params->get( 's5mp_description25', '' );
$s5mp_movie25   		= $params->get( 's5mp_movie25', '' );
$s5mp_icon25   		= $params->get( 's5mp_icon25', '' );

$s5mp_ratio26   		= $params->get( 's5mp_ratio26', '' );
$s5mp_name26   		= $params->get( 's5mp_name26', '' );
$s5mp_description26	= $params->get( 's5mp_description26', '' );
$s5mp_movie26   		= $params->get( 's5mp_movie26', '' );
$s5mp_icon26   		= $params->get( 's5mp_icon26', '' );

$s5mp_ratio27   		= $params->get( 's5mp_ratio27', '' );
$s5mp_name27   		= $params->get( 's5mp_name27', '' );
$s5mp_description27	= $params->get( 's5mp_description27', '' );
$s5mp_movie27   		= $params->get( 's5mp_movie27', '' );
$s5mp_icon27   		= $params->get( 's5mp_icon27', '' );

$s5mp_ratio28   		= $params->get( 's5mp_ratio28', '' );
$s5mp_name28   		= $params->get( 's5mp_name28', '' );
$s5mp_description28	= $params->get( 's5mp_description28', '' );
$s5mp_movie28   		= $params->get( 's5mp_movie28', '' );
$s5mp_icon28   		= $params->get( 's5mp_icon28', '' );

$s5mp_ratio29   		= $params->get( 's5mp_ratio29', '' );
$s5mp_name29   		= $params->get( 's5mp_name29', '' );
$s5mp_description29	= $params->get( 's5mp_description29', '' );
$s5mp_movie29   		= $params->get( 's5mp_movie29', '' );
$s5mp_icon29   		= $params->get( 's5mp_icon29', '' );

$s5mp_ratio30   		= $params->get( 's5mp_ratio30', '' );
$s5mp_name30   		= $params->get( 's5mp_name30', '' );
$s5mp_description30	= $params->get( 's5mp_description30', '' );
$s5mp_movie30   		= $params->get( 's5mp_movie30', '' );
$s5mp_icon30   		= $params->get( 's5mp_icon30', '' );




?>



<?php if ($pretext != "") { ?>
<br />
<?php echo $pretext ?>
<br /><br />
<?php } ?>

<?php
$playList = array();
$playList [] = array(
'ratio' => ''.$s5mp_ratio1.'',
'name' => ''.$s5mp_name1.'',
'description' => ''.$s5mp_description1.'',
'movie' => ''.$s5mp_movie1.'',
'icon' => ''.$s5mp_icon1.'');


if ($s5mp_movie2 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio2.'',
'name' => ''.$s5mp_name2.'',
'description' => ''.$s5mp_description2.'',
'movie' => ''.$s5mp_movie2.'',
'icon' => ''.$s5mp_icon2.'');
}

if ($s5mp_movie3 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio3.'',
'name' => ''.$s5mp_name3.'',
'description' => ''.$s5mp_description3.'',
'movie' => ''.$s5mp_movie3.'',
'icon' => ''.$s5mp_icon3.'');
}

if ($s5mp_movie4 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio4.'',
'name' => ''.$s5mp_name4.'',
'description' => ''.$s5mp_description4.'',
'movie' => ''.$s5mp_movie4.'',
'icon' => ''.$s5mp_icon4.'');
}

if ($s5mp_movie5 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio5.'',
'name' => ''.$s5mp_name5.'',
'description' => ''.$s5mp_description5.'',
'movie' => ''.$s5mp_movie5.'',
'icon' => ''.$s5mp_icon5.'');
}

if ($s5mp_movie6 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio6.'',
'name' => ''.$s5mp_name6.'',
'description' => ''.$s5mp_description6.'',
'movie' => ''.$s5mp_movie6.'',
'icon' => ''.$s5mp_icon6.'');
}

if ($s5mp_movie7 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio7.'',
'name' => ''.$s5mp_name7.'',
'description' => ''.$s5mp_description7.'',
'movie' => ''.$s5mp_movie7.'',
'icon' => ''.$s5mp_icon7.'');
}

if ($s5mp_movie8 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio8.'',
'name' => ''.$s5mp_name8.'',
'description' => ''.$s5mp_description8.'',
'movie' => ''.$s5mp_movie8.'',
'icon' => ''.$s5mp_icon8.'');
}

if ($s5mp_movie9 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio9.'',
'name' => ''.$s5mp_name9.'',
'description' => ''.$s5mp_description9.'',
'movie' => ''.$s5mp_movie9.'',
'icon' => ''.$s5mp_icon9.'');
}

if ($s5mp_movie10 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio10.'',
'name' => ''.$s5mp_name10.'',
'description' => ''.$s5mp_description10.'',
'movie' => ''.$s5mp_movie10.'',
'icon' => ''.$s5mp_icon10.'');
}

if ($s5mp_movie11 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio11.'',
'name' => ''.$s5mp_name11.'',
'description' => ''.$s5mp_description11.'',
'movie' => ''.$s5mp_movie11.'',
'icon' => ''.$s5mp_icon11.'');
}

if ($s5mp_movie12 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio12.'',
'name' => ''.$s5mp_name12.'',
'description' => ''.$s5mp_description12.'',
'movie' => ''.$s5mp_movie12.'',
'icon' => ''.$s5mp_icon12.'');
}

if ($s5mp_movie13 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio13.'',
'name' => ''.$s5mp_name13.'',
'description' => ''.$s5mp_description13.'',
'movie' => ''.$s5mp_movie13.'',
'icon' => ''.$s5mp_icon13.'');
}

if ($s5mp_movie14 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio14.'',
'name' => ''.$s5mp_name14.'',
'description' => ''.$s5mp_description14.'',
'movie' => ''.$s5mp_movie14.'',
'icon' => ''.$s5mp_icon14.'');
}

if ($s5mp_movie15 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio15.'',
'name' => ''.$s5mp_name15.'',
'description' => ''.$s5mp_description15.'',
'movie' => ''.$s5mp_movie15.'',
'icon' => ''.$s5mp_icon15.'');
}

if ($s5mp_movie16 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio16.'',
'name' => ''.$s5mp_name16.'',
'description' => ''.$s5mp_description16.'',
'movie' => ''.$s5mp_movie16.'',
'icon' => ''.$s5mp_icon16.'');
}

if ($s5mp_movie17 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio17.'',
'name' => ''.$s5mp_name17.'',
'description' => ''.$s5mp_description17.'',
'movie' => ''.$s5mp_movie17.'',
'icon' => ''.$s5mp_icon17.'');
}

if ($s5mp_movie18 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio18.'',
'name' => ''.$s5mp_name18.'',
'description' => ''.$s5mp_description18.'',
'movie' => ''.$s5mp_movie18.'',
'icon' => ''.$s5mp_icon18.'');
}

if ($s5mp_movie19 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio19.'',
'name' => ''.$s5mp_name19.'',
'description' => ''.$s5mp_description19.'',
'movie' => ''.$s5mp_movie19.'',
'icon' => ''.$s5mp_icon19.'');
}

if ($s5mp_movie20 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio20.'',
'name' => ''.$s5mp_name20.'',
'description' => ''.$s5mp_description20.'',
'movie' => ''.$s5mp_movie20.'',
'icon' => ''.$s5mp_icon20.'');
}

if ($s5mp_movie21 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio21.'',
'name' => ''.$s5mp_name21.'',
'description' => ''.$s5mp_description21.'',
'movie' => ''.$s5mp_movie21.'',
'icon' => ''.$s5mp_icon21.'');
}

if ($s5mp_movie22 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio22.'',
'name' => ''.$s5mp_name22.'',
'description' => ''.$s5mp_description22.'',
'movie' => ''.$s5mp_movie22.'',
'icon' => ''.$s5mp_icon22.'');
}

if ($s5mp_movie23 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio23.'',
'name' => ''.$s5mp_name23.'',
'description' => ''.$s5mp_description23.'',
'movie' => ''.$s5mp_movie23.'',
'icon' => ''.$s5mp_icon23.'');
}

if ($s5mp_movie24 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio24.'',
'name' => ''.$s5mp_name24.'',
'description' => ''.$s5mp_description24.'',
'movie' => ''.$s5mp_movie24.'',
'icon' => ''.$s5mp_icon24.'');
}

if ($s5mp_movie25 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio25.'',
'name' => ''.$s5mp_name25.'',
'description' => ''.$s5mp_description25.'',
'movie' => ''.$s5mp_movie25.'',
'icon' => ''.$s5mp_icon25.'');
}

if ($s5mp_movie26 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio26.'',
'name' => ''.$s5mp_name26.'',
'description' => ''.$s5mp_description26.'',
'movie' => ''.$s5mp_movie26.'',
'icon' => ''.$s5mp_icon26.'');
}

if ($s5mp_movie27 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio27.'',
'name' => ''.$s5mp_name27.'',
'description' => ''.$s5mp_description27.'',
'movie' => ''.$s5mp_movie27.'',
'icon' => ''.$s5mp_icon27.'');
}

if ($s5mp_movie28 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio28.'',
'name' => ''.$s5mp_name28.'',
'description' => ''.$s5mp_description28.'',
'movie' => ''.$s5mp_movie28.'',
'icon' => ''.$s5mp_icon28.'');
}

if ($s5mp_movie29 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio29.'',
'name' => ''.$s5mp_name29.'',
'description' => ''.$s5mp_description29.'',
'movie' => ''.$s5mp_movie29.'',
'icon' => ''.$s5mp_icon29.'');
}

if ($s5mp_movie30 != "") { 
$playList [] = array(
'ratio' => ''.$s5mp_ratio30.'',
'name' => ''.$s5mp_name30.'',
'description' => ''.$s5mp_description30.'',
'movie' => ''.$s5mp_movie30.'',
'icon' => ''.$s5mp_icon30.'');
}


$doc = new DOMDocument();
$doc->formatOutput = true;

$r = $doc->createElement( "playList" );
$doc->appendChild( $r );

foreach( $playList as $item )
{
$b = $doc->createElement( "item" );

$ratio = $doc->createElement( "ratio" );
$ratio->appendChild(
$doc->createTextNode( $item['ratio'] )
);
$b->appendChild( $ratio );

$name = $doc->createElement( "name" );
$name->appendChild(
$doc->createTextNode( $item['name'] )
);
$b->appendChild( $name );

$description = $doc->createElement( "description" );
$description->appendChild(
$doc->createTextNode( $item['description'] )
);
$b->appendChild( $description );

$movie = $doc->createElement( "movie" );
$movie->appendChild(
$doc->createTextNode( $item['movie'] )
);
$b->appendChild( $movie );

$icon = $doc->createElement( "icon" );
$icon->appendChild(
$doc->createTextNode( $item['icon'] )
);
$b->appendChild( $icon );

$r->appendChild( $b );
}

$doc->save("playlist.xml")
?>


<script type="text/javascript" src="<?php echo $LiveSite?>modules/mod_s5_mediaplayer/library/script.js"></script>

<!--url's used in the movie-->
<!--text used in the movie-->
<!-- saved from url=(0013)about:internet -->
<script type="text/javascript">
	AC_FL_RunContent(
		'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0',
		'width', '<?php echo $width ?>',
		'height', '<?php echo $height ?>',
		'src', '<?php if ($lightdark == "dark") { ?>videoPlayer<?php } ?><?php if ($lightdark == "light") { ?>videoPlayerLight<?php } ?>',
		'quality', 'high',
		'pluginspname', 'http://www.adobe.com/go/getflashplayer',
		'align', 'middle',
		'play', 'true',
		'loop', 'true',
		'scale', 'showall',
		'wmode', 'opaque',
		'devicefont', 'false',
		'id', 'videoPlayer',
		'bgcolor', '#<?php echo $mpbgcolor ?>',
		'name', 'videoPlayer',
		'menu', 'true',
		'allowFullScreen', 'true',
		'allowScriptAccess','sameDomain',
		'FlashVars','playlistURL=playlist.xml',
		'movie', '<?php echo $LiveSite ?>modules/mod_s5_mediaplayer/<?php if ($lightdark == "dark") { ?>videoPlayer<?php } ?><?php if ($lightdark == "light") { ?>videoPlayerLight<?php } ?>',
		'salign', ''
		); //end AC code
</script>



<noscript>
	<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=10,0,0,0" width="<?php echo $width ?>" height="<?php echo $height ?>" id="videoPlayer" align="middle">
	<param name="allowScriptAccess" value="sameDomain" />
	<param name="allowFullScreen" value="false" />
	<param name="movie" value="<?php echo $LiveSite ?>modules/mod_s5_mediaplayer/<?php if ($lightdark == "dark") { ?>videoPlayer.swf<?php } ?><?php if ($lightdark == "light") { ?>videoPlayerLight.swf<?php } ?>" />
	<param name="quality" value="high" />
	<param name="FlashVars" value="playlistURL=playlist.xml" />
	<param name="bgcolor" value="#<?php echo $mpbgcolor ?>" />	
	<script type="text/javascript">//<![CDATA[
    document.write('<embed src="<?php echo $LiveSite ?>modules/mod_s5_mediaplayer/<?php if ($lightdark == "dark") { ?>videoPlayer.swf<?php } ?><?php if ($lightdark == "light") { ?>videoPlayerLight.swf<?php } ?>" quality="high" FlashVars="playlistURL=playlist.xml" bgcolor="#<?php echo $mpbgcolor ?>" width="<?php echo $width ?>" height="<?php echo $height ?>" name="videoPlayer" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspname="http://www.adobe.com/go/getflashplayer" />');
//]]></script>
	</object>
</noscript>



<?php
/**
 * Helper class for mod_extCoppermine module
 *
 * @package    Joomla 1.5
 * @subpackage Modules
 * @license    GNU/GPL version
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class mod_helper
 {
    function getcpm( $params ) {
$document = &JFactory::getDocument();
$document->addStylesheet( JURI::base(). 'modules/mod_extcoppermine/css/mod_extcoppermine.css');

//begin module parameters
        $cpmFetch           = $params->get('cpmFetch');// Pfad zu cpmfetch
        $cpmfetch_config    = $params->get('cpmfetch_config'); // Dateiname fuer Konfig-Datei
        $settings           = $params->get('settings');// Einstellung
        $quelle             = $params->get('quelle'); // Option album= Album, cat=Kategegorie, album_cat=beides, pid=ein Bild
        $private_album      = $params->get('private_album'); // Anzeige von Bildern aus nonPublic Alben
        $id_album           = $params->get('id_album'); // Option Album
        $id_category        = $params->get('id_category'); // Option Kategorie
        $id_pid             = $params->get('id_pid'); // Option ein Bild
        $typ                = $params->get('typ'); // Option last= zuletzt hinzugefuegt, random = Zufall, mostviewed = am meisten angesehen, toprated = am besten bewertet
        $keyword            = $params->get('keyword'); // Search keywords
        $text               = $params->get('text'); // Search in text
        $owner              = $params->get('owner'); // filter for specific owner
        $column             = $params->get('column'); // Spalte
        $rows               = $params->get('rows');
        $id_album           = $params->get('id_album'); // Nummer des Albums
        $id_category        = $params->get('id_category'); // Nummer der Kategorie
        $imagesize          = $params->get ('imagesize'); // thumb = Thumbnail, int = Intermediate, large = Gross
        $imagelink          = $params->get ('imagelink'); // standard = normaler Bildlink, none = kein Link, album = Link zum Album, large = Link zum Bild, thumb - Thumbnail ,category - Kategorie
        $windowtarget       = $params->get ('windowtarget'); // _parent = gleiches Fenster, _blank = Neues Fenster
        $subtitle           = $params->get ('subtitle'); // Yes - Anzeige des Subtitels
        $subtitlelink       = $params->get ('subtitlelink'); // Yes - Anzeige des Subtitels als Link, No, normaler Text
        $noimage            = $params->get ('noimage'); // Yes - Anzeige aller Bilder, Noimage - keine Bilder
        $css_choice         = $params->get('css_choice'); //  Stil des CSS  1,2,3,4
        $css_imagestyle     = $params->get('css_cpgimage'); // IMG
        $css_table          = $params->get('css_cpgtable'); // TABLE
        $css_tablehead      = $params->get('css_cpgtablehead'); // TH
        $css_row            = $params->get('css_cpgrow');       // TR
        $css_cell           = $params->get('css_cpgcolumn'); // TD
        $css_link           = $params->get('css_cpglink'); // A
        $imagewidth         = $params->get('cpgimagewidth');
        $imageheight        = $params->get('cpgimageheight');
        $alttag             = $params->get('alttag');
        $moduleclass_sfx    = $params->get('moduleclass_sfx');

    // ----- highslide options -----
        $hsPathOption			= $params->get('hsPathOption');
		$hsAddoptions			= $params->get('hsAddoptions');
        $hsPath					= $params->get('hsPath');
		$hsOutlineType			= $params->get('hsOutlineType');
		$hsAlign				= $params->get('hsAlign');
		$hsCredits				= $params->get('hsCredits');
		$hsCreditsText			= $params->get('hsCreditsText');
		$hsCreditsLink			= $params->get('hsCreditsLink');
		$hsCreditsTitle			= $params->get('hsCreditsTitle');
		$hsAutosize				= $params->get('hsAutosize');
		$hsDimmingOpacity		= $params->get('hsDimmingOpacity');
		$hsBlur					= $params->get('hsBlur');
		$hsLoadingText			= $params->get('hsLoadingText');
		$hsCaptionEval			= $params->get('hsCaptionEval');
		$useHS = false;
        $hsOptions ="";
		$html = "";

		$hsBase    = JURI::base();
		if ($hsPathOption == "1")
		{
			$hsGraphics =   $hsBase . $hsPath . '/graphics/';
		
		}
		elseif ($hsPathOption == "0")
		{
			$hsGraphics =   $hsPath . '/graphics/';
		}
		
		$hsOptions .= 'hs.graphicsDir =\''.$hsGraphics .'\';'; 	//  Bestimmen des Pfades fuer die Grafikdateien von Highslide, notwendig fuer SEF
		

		// Zusammensetzen des Strings, entweder fuer Album/Kategorie/ Beides
$id="";
switch ($quelle)
{
case 'album':
    if ( $id_album != '')
    {
            $id = $quelle.'='.$id_album;
    }
    break;
case 'cat':
    if ( $id_category != '')
    {
    $id = $quelle.'='.$id_category;
    }
    break;
case 'album_cat':
    if ( $id_album !='')
    {
        $id = 'album='.$id_album;
    }
    if ( $id_album !='' and $id_category != '')
    {
        $id =':'.'cat='.$id_category;
    }
    if ( $id_category != '')
    {
    $id = 'cat='.$id_category;
    }
    break;
}
if ( $keyword != '')
{
    $id = $id.':keyword='.$keyword;
}
if ( $text != '')
{
    $id = $id.'text='.$text;
}
if ( $owner != '')
{
    $id = $id.'owner='.$owner;
}

// Insert parameters into cpmfetch_options
$gallery = $cpmFetch .'/'.$cpmfetch_config; // Anhaengen der Config Datei fuer cpmfetch

if ( file_exists ($cpmFetch.'/cpmfetch.php'))
{
	if ( file_exists ($gallery))
	{
	require_once $cpmFetch."/cpmfetch.php";
	$objCpm = new cpm($gallery);
	$objCpm ->cpm_setReturnType('html');
	}
}
else
{
echo ('Error opening the path to CpmFetch'. $cpmFetch.'<br/>name of configuration file:'.$gallery.'<br/>
 Please recheck the path for cpmFetch and the name of the configuration file at the module Backend');
return;
}

// Uebergeben der Parameter in das Options Feld

$options = '';
$pre = 'cpg_';
 $options ['subtitle'] = $subtitle;
 $options ['alttag'] = $alttag;
 $options ['imagestyle'] = $pre.'img_'.$css_choice;
 $options ['tablestyle'] = $pre.'table_'.$css_choice;
 $options ['cellstyle'] = $pre.'cell_'.$css_choice;
 $options ['tableheadstyle'] = $pre.'tablehead_'.$css_choice;
 $options ['rowstyle'] = $pre.'row_'.$css_choice;
 $options ['linkstyle'] = $pre.'link_'.$css_choice;


 if ($css_imagestyle <>'')
 	$options ['imagestyle'] = $css_imagestyle;

 if ($css_table <>'')
 	$options ['tablestyle'] = $css_table;
 if ($css_cell <>'')
 	$options ['cellstyle'] = $css_cell;
 if ($css_tablehead <>'')
 	$options ['tableheadstyle'] = $css_tablehead;
 if ($css_row <>'')
 	$options ['rowtyle'] = $css_row;
 if ($css_link <>'')
 	$options ['linkstyle'] = $css_link;


// Anzeige von Bildern ja/nein
if ($noimage <> '')
	$options ['noimage'] = $noimage;

//Anzeige Subtitlelink
if ($subtitlelink <> '')
	$options ['subtitlelink'] = $subtitlelink;
 $options ['imagesize'] = $imagesize;
 $options ['windowtarget'] = $windowtarget;

// Aenderung der Hoehe Breite des Bildes
if ($imageheight <> '')
            $options ['imageheight'] = $imageheight;
 if ($imagewidth <> '')
            $options ['imagewidth'] = $imagewidth;

 $options ['imagelink'] = $imagelink;
if ($imagelink <> '') {
            if ($imagelink == 'highslide_large' or $imagelink =='highslide_normal' )
                $useHS = true;
            else
                $options ['imagelink'] = $imagelink;
			}
        
if ($imagelink =='category')
{
	$options['linktemplate']= $objCpm->cfg['cpg_url'].'index.php?cat={{aCategory}}';
}

// Anzeige Bilder aus privaten Alben
if ( $private_album == '1')
    $objCpm->cpm_unlock_private(true);
else
    $objCpm->cpm_unlock_private(false);


	// Optionen fuer Highslide
if ($useHS == true) {
						
			if ( hsPathOption =="1")
			{
			if ( !file_exists ($hsBase . $hsPath . '/highslide-full.packed.js'))
				{
				echo ('Error opening the path to Highslide: '. $hsBase . $hsPath . '/highslide-full.packed.js.');
				return;
				}
			$document->addScript( $hsBase . $hsPath . '/highslide-full.packed.js');
			}
			else
			{	

				if ( !fopen ($hsPath . '/highslide-full.packed.js','r'))
				{
				echo ('Error opening the path to Highslide: '.$hsPath . '/highslide-full.packed.js.');
				return;
				}
				$document->addScript( $hsPath . '/highslide-full.packed.js');
			}
			$document->addStylesheet( JURI::base(). 'modules/mod_extcoppermine/css/highslide.css');
			if ($imagelink == 'highslide_large')
			{
				$options ['linktemplate'] = $objCpm->cfg['cpg_url'].'{{fullPathToFull}}" class="highslide" onclick="return hs.expand(this)"';
       		}

			if ($imagelink == 'highslide_normal')
			{
				$options ['linktemplate'] = $objCpm->cfg['cpg_url'].'{{fullPathToNormal}}" class="highslide" onclick="return hs.expand(this)"';
           	}

			$hsOptions .= $hsCredits;									// Shows a credit or not
			$hsOptions .= $hsAutosize;									// fit into browser window
			$hsOptions .= $hsAlign;										// aligns the Popup
			$hsOptions .= $hsBlockRightClick;							// disables Mouse Rightclick
			$hsOptions .= 'hs.creditsText=\''.$hsCreditsText.'\';'; 	// Credits Text
 			$hsOptions .= 'hs.creditsHref=\''.$hsCreditsLink.'\';'; 	// Link
			$hsOptions .= 'hs.creditsTitle=\''.$hsCreditsTitle.'\';'; 	// Text of the Tooltip
			
			if ($hsOutlineType <> "" )
			$hsOptions .= $hsOutlineType;

			if ($hsDimmingOpacity <> "") {
				$html .= '<style type="text/css">
				.highslide-dimming {background: black;position: absolute;}
				</style>';
				$hsOptions .= "hs.dimmingOpacity=".$hsDimmingOpacity.";";
			}
			if ($hsBlur == '1') {
				$html .= '<style type="text/css">
				.highslide-blur .highslide-image-blur {opacity: 0.75; filter: alpha(opacity=75);}
				</style>';
				$hsOptions .= 'hs.wrapperClassName=\'highslide-blur\';';
			}
			$hsOptions .= 'hs.loadingText=\''.$hsLoadingText.'\';';

			if ($hsCaptionEval <> '')
				$hsOptions .= 'hs.captionEval=\''.$hsCaptionEval.'\';';
			
			$html .= '<style type="text/css">
				.highslide-loading {background-image: url('.$hsGraphics.'loader.white.gif)};
				.highslide { cursor: url('.$hsGraphics.'zoomin.cur), pointer; }
					</style>';
	
			$html .="<script type='text/javascript'>".$hsOptions. ';'.$hsAddoptions."</script>";
}
switch ( $settings )
{
        case 'simple':
                $html .= $objCpm->cpm_viewMediaByPid($id_pid,$options);
                break;
        case 'advanced':
        {
        switch ($typ)
            {
                case 'last': //Zuletzt hinzugefuegt
                    $html .= $objCpm->cpm_viewLastAddedMediaFrom($id,$rows, $column, $options);
                    break;
                 case 'random': // Zufallsbilder
                      $html .= $objCpm->cpm_viewRandomMediaFrom($id,$rows, $column, $options);
                      break;
                case 'mostviewed': // am meisten angesehen
                      $html .= $objCpm->cpm_viewRandomMostViewedMediaFrom($id,$rows, $column, $options);
                      break;
                 case 'toprated': // am besten bewertet
                      $html .= $objCpm->cpm_viewTopRatedMediaFrom($id,$rows, $column, $options);
                      break;
                 case 'mostrated': // am haeufigsten bewertet
                      $html .= $objCpm->cpm_viewMostVotedMediaFrom($id,$rows, $column, $options);
                      break;
            case 'lastcommented': // zuletzt kommentiert;
              $html .= $objCpm-> cpm_viewLastCommentedImages  ($rows, $column,$options);
            break;
            }
        }
}
$objCpm->cpm_close();
return $html;
    }
}
?>
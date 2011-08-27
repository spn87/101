<?php
/**
*
* Vernissage - Flickr photos for Joomla!
*
* @package		Joomla
* @copyright	Copyright (C) 2010 Achim Fischer (Codingfish). All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @author		Achim Fischer - codingfish.com
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_BASE . DS . 'modules' . DS .'mod_vernissage' . DS . 'includes' . DS . 'phpflickr' . DS . 'phpFlickr.php');
require_once( JPATH_BASE . DS . 'configuration.php');


$document =& JFactory::getDocument();
$document->addStyleSheet( JURI::Root( true) . "/modules/mod_vernissage/css/vernissage.css");



// get parameters
$_flickr_apikey     = $params->get( 'flickr_apikey');
$_flickr_username   = $params->get( 'flickr_username');

$_number 		    = $params->get( 'number', 9 );
$_number_row 		= $params->get( 'number_row', 3 );

$_mode 		        = $params->get( 'mode', 1 ); // 1 = recently uploaded, 2 = random

$_cache_mode 		= $params->get( 'cache_mode', 0 ); // 0 = off, 1 = on
$_cache_time 		= $params->get( 'cache_time', 600 ); // default 600 seconds

$_show_poweredby 	= $params->get( 'show_poweredby', 1 );



$f = new phpFlickr( $_flickr_apikey);

if ($_cache_mode == 1) {

    $config = new JConfig();

    $_host 	    = $config->host;
    $_db 		= $config->db;
    $_dbprefix  = $config->dbprefix;
    $_user 	    = $config->user;
    $_password  = $config->password;

    $_connect = "mysql://" . $_user . ":" . $_password . "@" . $_host . "/" . $_db;

    $_cache_table = $_dbprefix . "vernissage_module_flickr_cache";
    

    $f->enableCache(
        "db",
        $_connect,
        $_cache_time,
        $_cache_table
    );

}



// get username NSID
$person = $f->people_findByUsername( $_flickr_username);

// get photo URLs
$photos_url = $f->urls_getUserPhotos( $person['id']);



if ( $_mode == 1) { // get recently uploaded photos
    $photos = $f->people_getPublicPhotos( $person['id'], NULL, NULL, $_number);
}
else { // calculate random photos, get 100 and randomize
    $photos = $f->people_getPublicPhotos( $person['id'], NULL, NULL, 100);
}


echo "<div>";

    // loop through photos and output html
    if ( $_mode == 1) { // get recently uploaded photos

        $i = 0;
        foreach ( ( array)$photos['photos']['photo'] as $photo) {

            $_src = $f->buildPhotoURL( $photo, "Square");

            echo "<a href='$photos_url$photo[id]' title='$photo[title]' target='_blank' >";
                echo "<img width='75px' height='75px' border='0' alt='$photo[title]' " . "src='" . $_src . "' class='cofiVernissageImage' >";
            echo "</a>";

            $i++;

            // line break after 3rd photo
            if ( $i % $_number_row == 0) {
                echo "<br>\n";
            }

        }

    }
    else { // get random photos

        $i = 0;
        $_random_photos = array();
        foreach ( ( array)$photos['photos']['photo'] as $photo) {

            $_src = $f->buildPhotoURL( $photo, "Square");

            // fill array
            $_random_photos[$i]['src'] = $_src;
            $_random_photos[$i]['href'] = $photos_url . $photo[id];
            $_random_photos[$i]['title'] = $photo[title];

            $i++;

        }

        // randomize array
        shuffle( $_random_photos);

        // second loop, now display random choice out of array
        for ( $i=0; $i<$_number;$i++) {

            echo "<a href='" . $_random_photos[$i]['href'] . "' title='" . $_random_photos[$i]['title'] . "' target='_blank' >";
                echo "<img width='75px' height='75px' border='0' alt='" . $_random_photos[$i]['title'] . "' " . "src='" . $_random_photos[$i]['src'] . "' class='cofiVernissageImage' >";
            echo "</a>";

            // line break after 3rd photo
            if ( $i+1 % $_number_row == 0) {
                echo "<br>\n";
            }

        }

    }

echo "</div>";



if ( $_show_poweredby == 1) {
	echo "<div class='cofiVernissagePoweredByText'>";
		echo "Powered by <a href='http://www.codingfish.com/products/vernissage' target='_blank' title='Vernissage' >Vernissage</a>";
	echo "</div>";
}
else {
    echo " <!-- ";
    echo "Vernissage Module ";
    echo "http://www.codingfish.com";
    echo " --> ";
}

?>
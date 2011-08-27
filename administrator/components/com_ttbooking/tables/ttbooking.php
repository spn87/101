<?php

defined( '_JEXEC' ) or die( 'Restricted access' );


class Tablettbooking extends JTable
{
	
  var $id=null;
  var $fullname=null;
  var $address=null;
  var $gender=null;
  var $dob=null;
  var $countries=null;
  var $mail=null;
  var $tcode=null;
  var $hotel=null;
  var $idt=null;
  var $arrivaldate=null;
  var $departuredate=null;
  var $rp_single=null;
  var $rp_double=null;
  var $rp_twin=null;
  var $np_adult=null;
  var $np_child=null;
  var $detail=null;

  
	function Tablettbooking(& $db) 
	{
		parent::__construct('jos_ttbooking', 'id', $db);
	}
}

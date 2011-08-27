<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class ttbookingsController extends JController
{

	function display()
	{
		parent::display();
	}
	
	function getContentView($row)
	{
		$tourCode = JText::_('Tour code');
		$html = "";
		$html .='<font size="+2"><u>'. $tourCode.':&nbsp; '. $row->id.'</u></font><br /><br />';
		$html .='<font size="+1">'.JText::_('Personal Information').'</font><br />';
		$html .='<ul style="list-style:square;font-size:16px;">';
		$html .='<li>'. JText::_('Tour code').':&nbsp; '. $row->id.'</li>';
		$html .='<li>'. JText::_('Customer Name').':&nbsp; '. $row->fullname.'</li>';
		$html .='<li>'.JText::_('Address').':&nbsp; '. $row->address.'</li>';
		$html .='<li>'.JText::_('Gender').':&nbsp;'. $row->gender.'</li>';
		$html .='<li>'. JText::_('Date of Birth').':&nbsp;'. $row->dob.'</li>';
		$html .='<li>'. JText::_('Country').':&nbsp;'. $row->countries.'</li>';
		$html .='<li>'. JText::_('E-mail').':&nbsp;'. $row->mail.'</li></ul>';
		$html .='<font size="+1">'. JText::_('Tour Information').'</font><br />';
		
		$html .='<ul style="list-style:square;font-size:16px;"><li>'. JText::_('Tourcode').':&nbsp;'. $row->tcode.'</li>';
		$html .='	<li>'. JText::_('Hotel').':&nbsp;'. $row->hotel.'</li>
  	<li>'. JText::_('ID').':&nbsp;'. $row->idt.'</li>
	<li>'. JText::_('Arrival Date').':&nbsp;'. $row->arrivaldate.'</li>
  	<li>'. JText::_('Departure Date').':&nbsp;'. $row->departuredate.'</li>
  	<li>
    	'. JText::_('Room Preference').':'. JText::_('Single').'&nbsp;'. $row->rp_single.'
		&nbsp;&nbsp;'. JText::_('Double').':&nbsp;'. $row->rp_double.'
		&nbsp;&nbsp;'. JText::_('Twin').':&nbsp;'. $row->rp_twin.'
    </li>
  	
  	<li>'. JText::_('Adult').':&nbsp;'. $row->np_adult.'</li>
  	<li>'. JText::_('Child').':&nbsp;'. $row->np_child.'</li>
  	<li>'. JText::_('Detail').':&nbsp;'. $row->detail.'</li>';

 
	
		return $html;
	}
	
	function getBooking($id)
	{
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM jos_ttbooking where id in ($id)");
		$db->query();
		$booking=$db->loadObject();
		
		return $booking;
	}
	
	function report()
	{
		$act=JRequest::getWord('controller');
		$id=JRequest::getVar('cid');
		for($i=0;$i<count($id);$i++){$stid=$stid.$id[$i].",";}
		$stid=$stid."0";
		
		$db = JFactory::getDBO();
		$db->setQuery("SELECT * FROM jos_ttbooking where id in ($stid)");
		$db->query();
		$booking=$db->loadObjectList();
		
		?>

    <input type="button" value="Print" onclick="printSelection(document.getElementById('txtHint'));return false " /> 
     <div id="txtHint" style="margin-left:70px;">
     <br />
    <font size="+1">Abktour Col,LTD</font>&nbsp;&nbsp;
	<?php 
		if($act=='ttbooking')echo 'Booking';   
		if($act=='ttbookingcheckin') echo 'Checkin';
		if($act=='ttbookingcheckout') echo 'Chectout';
	?>
    <hr /> 
<?php
	
	$k = 0;
	for ($i=0, $n=count($booking ); $i < $n; $i++)	
	{
		$row = &$booking[$i];
		echo $this->getContentView($row);
	}?>
</div>	
	<?php 
}
}?>


<script type="text/javascript">
function printSelection(node)
{

  var content=node.innerHTML
  var pwin=  window.open ("", "print_content","location=1,status=0,scrollbars=1, width=800,height=500");

  pwin.document.open();
  pwin.document.write('<html><body onload="window.print()">'+content+'</body></html>');
  pwin.document.close();
 
  //setTimeout(function(){pwin.close();},1000);

}
</script>

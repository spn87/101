

<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php 
jimport("countries.country");
$contries = countryArray();

$hotelTypes = array("**","***","****","*****","Guesthouse");


$tour = array();
$tour["tour_code"] = "";
$tour["idt"] = null;
if (JRequest::getCmd("id"))
{
	$id = JRequest::getCmd("id",0);
	$db = JFactory::getDBO();
	
	$query = "SELECT id,alias FROM #__content WHERE id='$id'";
	$db->setQuery($query);
	
	$tour = $db->loadAssoc();
	$tour["tour_code"] = $tour["alias"];
	$tour["idt"] = $tour["id"];
	
}
?>
<style>
	.text_area{border:1px #096 solid;}
</style>

<form action="index.php?option=com_ttbooking&task=save" method="post" onsubmit="return chk()" id="bform">
<div class="col100">
		<div style="background:#093;color:#FFF;font-size:14px;width:300px;"><?php echo JText::_( 'Personal Information' ); ?></div><br />
		<div style="background:#FF9"><br />
		<table class="admintable">
        <!--Full Name-->
		<tr>
			<td width="100" align="right" class="key">
				<label for="fullname">
					<?php echo JText::_( 'Full Name' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area req" type="text" name="fullname" id="fullname" size="32" maxlength="250" value="" />
			</td>
		</tr>
        
        <!--Address-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="address">
					<?php echo JText::_( 'Address' ); ?>:
				</label>
			</td>
			<td><textarea class="text_area" name="address" id="address" cols="40" rows="4"></textarea></td>
		</tr>
        
        <!--Gender-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="gender">
					<?php echo JText::_( 'Gender' ); ?>:
				</label>
			</td>
			<td>
				<select  class="text_area req" type="text" name="gender" id="gender">
					<option value="Male">M</option>
					<option value"Female">F</option>
				</select>
			</td>
		</tr>
        
        <!--Data of Birth-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="dob">
					<?php echo JText::_( 'Date of Birth' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area req" type="text" name="dob" id="dob" size="20" maxlength="250" value="" />
			</td>
		</tr>
        
        <!--Countries-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="countries">
					<?php echo JText::_( 'Countries' ); ?>:
				</label>
			</td>
			<td>
				<select  class="text_area req" type="text" name="countries" id="countries">
					<?php foreach ($contries as $k=>$v):?>
					<option value="<?php echo $v?>"><?php echo $v;?></option>
					<?php endforeach;?>
				</select>
			</td>
		</tr>
        
        <!--mail-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="mail">
					<?php echo JText::_( 'Mail' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="mail" id="mail" size="32" maxlength="250" value="" />
			</td>
		</tr>
        
        
	</table><br />
	</div>
    <br /><br />
  
    <div style="background:#093;color#FFF;font-size:14px;color:#FFF;width:300px;"><?php echo JText::_( 'Tour Information' ); ?></div><br />
		<div style="background:#FF9"><br />
		<table class="admintable">
        <!--Tours code-->
		<tr>
			<td width="100" align="right" class="key">
				<label for="tcode">
					<?php echo JText::_( 'Tour Code' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area req" type="text" name="tcode" id="tcode" size="32" maxlength="250" value="<?php echo $tour["tour_code"];?>" <?php echo ($tour["tour_code"]!="") ? " readonly='readonly'":""?>/>
			</td>
		</tr>
        
        <!--Hotel-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="hotel">
					<?php echo JText::_( 'Hotel' ); ?>:
				</label>
			</td>
			

			<td>
				<select class="text_area req" type="text" name="hotel" id="hotel">
					
				<?php foreach ($hotelTypes as $t):?>
					<option  style='font-size:16px;color:red' value="<?php echo $t?>"><?php echo $t;?></option>
				<?php endforeach;?>
				</select>
			</td>
			
		</tr>
        
        <!--departure date-->
        	<tr>
			
			<td width="100" align="right" class="key">
				<label for="arrivaldate">
					<?php  echo JText::_( 'Arrival Date'); ?>:
				</label>
			</td>
			<td>
				<input class="text_area req" type="text" name="arrivaldate" id="arrivaldate" size="20" maxlength="250" value="" />
			</td>

			<td width="100" align="right" class="key">
				<label for="departuredate">
					<?php echo JText::_( 'Departure Date' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area req" type="text" name="departuredate" id="departuredate" size="20" maxlength="250" value="" />
			</td>

		</tr>
        
        <!--Room Preference-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="rp_single">
					<?php echo JText::_( 'Room Preference' ); ?>:
				</label>
			</td>
			<td>
				<? echo JText::_('Single')?>: &nbsp; 
                <select id="rp_single" name="rp_single">
                	<?php for($i=0;$i<30;$i++){echo "<option value='$i'>$i</optoin>";}?>
                </select>
                
				<?php echo JText::_('Double') ?>: &nbsp;<select id="rp_double" name="rp_double">
                	<?php for($i=0;$i<30;$i++){echo "<option value='$i'>$i</optoin>";}?>
                </select>
                	
				<?php echo JText::_('Twin') ?>: &nbsp;
                <select id="rp_twin" name="rp_twin">
                	<?php for($i=0;$i<30;$i++){echo "<option value='$i'>$i</optoin>";}?>
                </select>
			</td>
		</tr>
        
         <!--Adult-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="np_adult">
					<?php echo JText::_( 'Adult' ); ?>
				</label>
			</td>
			<td>
            	<select id="np_adult" name="np_adult">
                	<?php for($i=0;$i<30;$i++){echo "<option value='$i'>$i</optoin>";}?>
                </select>
				
			</td>
		</tr>
        
         <!--Child-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="np_child">
					<?php echo JText::_( 'Child' ); ?>
				</label>
			</td>
			<td>
            	<select id="np_child" name="np_child">
                	<?php for($i=0;$i<30;$i++){echo "<option value='$i'>$i</optoin>";}?>
                </select>
			</td>
		</tr>
        
         <!--detail-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="detail">
					<?php echo JText::_( 'Detail' ); ?>:
				</label>
			</td>
			<td>
				<textarea class="text_area"  name="detail" id="detail" cols="40" rows="5" ></textarea>
			</td>
		</tr>
        

	</table><br />
</div>
    
</div>
<div class="clr"></div><hr />

<div align="center"> <input type="submit" value="<?php echo ($_GET['lang']=='en')?'Booking':'R&eacute;servation';?>" id="Booking" name="Booking" /> </div>

<input type="hidden" name="option" value="com_ttbooking" />
<input type="hidden" name="id" value="" />
<input type="hidden" name="task" value="save" />
<input type="hidden" name="controller" value="ttbooking" />
<input type="hidden" name="idt" value="<?php echo $tour["idt"];?>" />
</form>
<script>
var o = document.getElementsByClassName("req");
function chk()
{
	bReset();
	var j = 0;
	for (i = 0; i < o.length; i++)
	{
		if (o[i].value == "" || o[i].value=="..Require..")
		{
			j++;
			o[i].style.border = "1px solid red";
			o[i].value="..Require..";
		}
	}
	if (j>0){alert('field is require !');return false;}
}
function bReset()
{
	for (i = 0; i < o.length; i++)
	{
		o[i].style.border = "1px #ccc solid";
	}
}

var elInput = document.getElementById("bform").getElementsByTagName("input");
var elTextarea = document.getElementById("bform").getElementsByTagName("textarea"); 

var elAll = new Array();
for (i = 0; i < elTextarea.length; i++)
{
	elAll.push(elTextarea[i]);
}
for (i = 0; i < elInput.length; i++)
{
	elAll.push(elInput[i]);
}

for (i = 0; i < elAll.length; i++)
{
	elAll[i].onfocus = function()
	{
		if (this.getAttribute("readonly"))
		{
			return true;
		}
		this.value = "..Require..";
		if(this.value=="..Require..")
		{
			this.value="";
			document.getElementById('Booking').setAttribute('value','Booking');
		}
	}

}

</script>



<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Personal Information' ); ?></legend>

		<table class="admintable">
        <!--Full Name-->
		<tr>
			<td width="100" align="right" class="key">
				<label for="fullname">
					<?php echo JText::_( 'Full name' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="fullname" id="fullname" size="32" maxlength="250" value="<?php echo $this->booking->fullname;?>" />
			</td>
		</tr>
        
        <!--Address-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="address">
					<?php echo JText::_( 'Address' ); ?>:
				</label>
			</td>
			<td><textarea class="text_area" type="text" name="address" id="address" cols="40" rows="4"> <?php echo $this->booking->address;?> </textarea></td>
		</tr>
        
        <!--Gender-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="gender">
					<?php echo JText::_( 'Gender' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="gender" id="gender" size="12" maxlength="250" value="<?php echo $this->booking->gender;?>" />
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
				<input class="text_area" type="text" name="dob" id="dob" size="20" maxlength="250" value="<?php echo $this->booking->dob;?>" />
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
				<input class="text_area" type="text" name="countries" id="countries" size="32" maxlength="250" value="<?php echo $this->booking->countries;?>" />
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
				<input class="text_area" type="text" name="mail" id="mail" size="32" maxlength="250" value="<?php echo $this->booking->mail;?>" />
			</td>
		</tr>
        
        
	</table>
	</fieldset>
    
    <fieldset class="adminform">
    <legend><?php echo JText::_( 'Tour Information' ); ?></legend>

		<table class="admintable">
        <!--Tours code-->
		<tr>
			<td width="100" align="right" class="key">
				<label for="tcode">
					<?php echo JText::_( 'Tour Code' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="tcode" id="tcode" size="32" maxlength="250" value="<?php echo $this->booking->tcode;?>" />
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
				<input class="text_area" type="text" name="hotel" id="hotel" size="32" maxlength="250" value="<?php echo $this->booking->hotel;?>" />
			</td>
		</tr>
        
        <!--departure date-->
        <tr>
			<td width="100" align="right" class="key">
				<label for="arrivaldate">
					<?php echo JText::_( 'Arrival Date' ); ?>:
				</label>
			</td>
			<td>
		<input class="text_area" type="text" name="arrivaldate" id="arrivaldate" size="20" maxlength="250" value="<?php echo $this->booking->arrivaldate;?>" />
			</td>

			<td width="100" align="right" class="key">
				<label for="departuredate">
					<?php echo JText::_( 'Departure Date' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="departuredate" id="departuredate" size="20" maxlength="250" value="<?php echo $this->booking->departuredate;?>" />
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
				<?php echo JText::_( 'Single' )?>: &nbsp; <input class="text_area" type="text" name="rp_single" id="rp_single" size="12" maxlength="250" value="<?php echo $this->booking->rp_single;?>" />
				<?php echo JText::_( 'Double' )?>: &nbsp;<input class="text_area" type="text" name="rp_double" id="rp_double" size="12" maxlength="250" value="<?php echo $this->booking->rp_double;?>" />
				<?php echo JText::_( 'Twin' )?>: &nbsp;<input class="text_area" type="text" name="rp_twin" id="rp_twin" size="12" maxlength="250" value="<?php echo $this->booking->rp_twin;?>" />
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
				<input class="text_area" type="text" name="np_adult" id="np_adult" size="12" maxlength="250" value="<?php echo $this->booking->np_adult;?>" />
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
				<input class="text_area" type="text" name="np_child" id="np_child" size="12" maxlength="250" value="<?php echo $this->booking->np_child;?>" />
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
				<textarea class="text_area" type="text" name="detail" id="detail" cols="40" rows="5" > <?php echo $this->booking->detail;?></textarea>
			</td>
		</tr>
        

	</table>
	</fieldset>
    
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_ttbooking" />
<input type="hidden" name="id" value="<?php echo $this->booking->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="ttbooking" />
</form>

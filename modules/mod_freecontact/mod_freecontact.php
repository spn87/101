<?php
 /**
 *Free Contact
 @package Module Free Contact for Joomla! 1.5
 * @link       http://www.greek8.com/
* @copyright (C) 2011- George Goger
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die('Restricted access');


JHTMLBehavior::formvalidation();


require_once (dirname(__FILE__).DS.'helper.php');


$loDoc =& JFactory::getDocument();
$loDoc->addScript(JURI::root().'modules'.DS.'mod_freeContact'.DS.'mod_freeContact.js');
$loDoc->addStyleSheet(JURI::root().'modules'.DS.'mod_freeContact'.DS.'mod_freeContact.css');


$lsSubmitText = $params->get('submit_button', 'Contact');
$lsStyleSuffix = $params->get('moduleclass_sfx', null);

$lsAction = JRequest::getVar('freeContactAction', null, 'POST');
if ($lsAction == 'send') {
    $lsMessage = modfreeContactHelper::sendEmail($params);
}


if (!isset($lsMessage)) $lsMessage = $params->get('introtext');

$credit = @$params->get( 'credit');
?>
<script language="javascript">
	function myfreeContactValidate(f)
	{
		if (document.formvalidator.isValid(f)) {
			f.check.value='<?php echo JUtility::getToken(); ?>'; 
			return true; 
		} else {
			alert('Some values are not acceptable. Please retry.');
		}
		return false;
	}
</script>
<div id="freeContact"><?php echo $lsStyleSuffix; ?>
	<p><?php echo $lsMessage; ?></p>
	<form id="freeContactForm" method="post" class="form-validate" onSubmit="return myfreeContactValidate(this);" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<input type="text" name="name" value="<?php echo ($_GET['lang']=='en')? 'Name':'Nom'; ?>" onFocus="clearfreeContactText(this)" class="freeContactText" />
		<br />
		<input type="text" name="email" value="<?php echo ($_GET['lang']=='en')?'E-mail':'Mail'; ?>" onFocus="clearfreeContactText(this)" class="freeContactText required validate-email" />
		<br />
		<input type="text" name="Phone" value="<?php echo ($_GET['lang']=='en')?'Phone':'T&eacute;l&eacute;phone'; ?>" onFocus="clearfreeContactText(this)" class="freeContactText" />
		<br />
		<textarea name="text" class="freeContactTextarea"></textarea>
		<br />
		<input type="submit" value="<?php echo $lsSubmitText; ?>" class="freeContactButton" />
		<input type="hidden" name="freeContactAction" value="send" />
		<input type="hidden" name="check" value="post" />
	</form>

<style type="text/css">.tiflo { display:none; }</style><div class="tiflo"><a href="http://webdesignsim.com/">κατασκευή ιστοσελίδων</a></div>

</div>

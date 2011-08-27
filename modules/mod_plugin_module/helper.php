<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class PluginModuleHelper
{
    function LoadPluginModule($params)
    {      
    if ($params->get('type')==1)
    {
        if ($params->get('areadditional')==1)
            $miscinfo->text = $params->get('advancedbefore').'{'.$params->get('plugin').' '.$params->get('additional').'}'.$params->get('command').'{/'.$params->get('plugin').'}'.$params->get('advancedafter');
        else
        $miscinfo->text = $params->get('advancedbefore').'{'.$params->get('plugin').'}'.$params->get('command').'{/'.$params->get('plugin').'}'.$params->get('advancedafter');
    }
    else
	{
		if ($params->get('command')=='')
			 $miscinfo->text = $params->get('advancedbefore').'{'.$params->get('plugin').'}'.$params->get('advancedafter');
		else
        	$miscinfo->text = $params->get('advancedbefore').'{'.$params->get('plugin').' '.$params->get('command').'}'.$params->get('advancedafter'); 
	}

    $output = JHTML::_('content.prepare', $miscinfo->text);
    echo ($output);
    }
}
?>
<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

// Require the base controller

require_once( JPATH_COMPONENT.DS.'controller.php' );

$controllerName = JRequest::getVar('view');
switch ($controllerName) 
{
	case"ttbookings":
		JSubMenuHelper::addEntry("<font color='red' style='background-color:#FCC'>".JText::_('Booking')."</font>", 'index.php?option=com_ttbooking&view=ttbookings', true );
		JSubMenuHelper::addEntry(JText::_('Checkin'), 'index.php?option=com_ttbooking&view=ttbookingcheckins');
		JSubMenuHelper::addEntry(JText::_('Checkout'), 'index.php?option=com_ttbooking&view=ttbookingcheckouts');
	break;
		
	case"ttbookingcheckins":
		JSubMenuHelper::addEntry(JText::_('Booking'), 'index.php?option=com_ttbooking&view=ttbookings');
		JSubMenuHelper::addEntry("<font color='red' style='background-color:#FCC'>".JText::_('Checkin')."</font>", 'index.php?option=com_ttbooking&view=ttbookingcheckins',true);
		JSubMenuHelper::addEntry(JText::_('CheckOut'), 'index.php?option=com_ttbooking&view=ttbookingcheckouts');
	break;
	
	case"ttbookingcheckouts":
		JSubMenuHelper::addEntry(JText::_('Booking'), 'index.php?option=com_ttbooking&view=ttbookings');
		JSubMenuHelper::addEntry(JText::_('CheckIn'), 'index.php?option=com_ttbooking&view=ttbookingcheckins');
		JSubMenuHelper::addEntry("<font color='red' style='background-color:#FCC'>".JText::_('Checkout')."</font>", 'index.php?option=com_ttbooking&view=ttbookingcheckouts',true);
	break;
	
	default :
		JSubMenuHelper::addEntry("<font color='red' style='background-color:#FCC'>".JText::_('Booking')."</font>"	, 'index.php?option=com_ttbooking&view=ttbookings', true );
		JSubMenuHelper::addEntry(JText::_('CheckIn'), 'index.php?option=com_ttbooking&view=ttbookingcheckins');
		JSubMenuHelper::addEntry(JText::_('CheckOut'), 'index.php?option=com_ttbooking&view=ttbookingcheckouts');
}



// Require specific controller if requested
if (!($controllerName = JRequest::getWord('controller')))
    {$controllerName = 'ttbooking';};


if($controllerName)
    {
        $path = JPATH_COMPONENT.DS.'controllers'.DS.$controllerName.'.php';
		
        if( file_exists($path))
            {
                require_once $path;
            } else
            {
                $controllerName = '';
            }
    }
$classname = 'ttbookingsController'.$controllerName;
// Create the controller
$controllerName = new $classname();

// Perform the Request task
if (!(JRequest::getVar('task'))) {$task = 'view';}
else{$task = JRequest::getVar('task');}
$controllerName->execute( $task );

// Redirect if set by the controller
$controllerName->redirect();


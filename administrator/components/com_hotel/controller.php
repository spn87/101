<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport("joomla.application.component.controller");

class HotelController extends JController
{
	public function index()
	{
		$view = &$this->getView();
		$model = &$this->getModel();
		$hotels = $model->getHotels();
		$view->index($hotels);
	}
	
	public function add()
	{
		$id = JRequest::getCmd("id",null);
		$model = $this->getModel();	
		
		$data = $model->getHotel($id);
		$view = &$this->getView();
		$view->add($model->getHotelGroup(),$data);
	}
	
	public function save()
	{
		if (!$_POST)
		{
			echo "Error";
			return;
		}
		
		$data = $_POST;
		$file = $_FILES['image'];
		if ($file['name'] != "")
		{
			$dest = JPATH_SITE.DS."images".DS."stories".DS."hotels".DS.$file["name"];
			
			if ($file["size"] > 0 && $file["size"] <= (1024*1024*1))
			{
				move_uploaded_file($file["tmp_name"],$dest);
			} else
			{
				echo "Image size is too big";
				exit();
			}
			$data['image'] = $file["name"];
		}
		$model = $this->getModel();
		if ($model->save($data))
			$this->setRedirect("index.php?option=com_hotel");
	}
	public function delete()
	{
		$id = JRequest::getCmd("id",null);
		$model = $this->getModel();

		$model->delete($id);
		$this->setRedirect("index.php?option=com_hotel");
	}
}
?>

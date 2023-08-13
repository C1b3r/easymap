<?php
namespace app\controllers;
use app\classes\Controller;
use app\classes\Session;
use app\model\Spot_Model;
use Helper;
use Illuminate\Http\Request;
use app\classes\Boot;

defined('ROOT_PATH') or exit('Direct access forbidden');

class Puntos_Controller extends Controller 
{
	
	public function __construct() 
	{
		$this->model = new Spot_Model();
	}

    public function getSpots() 
	{
		return $this->model->getSpots();
	}

	
}
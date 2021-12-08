<?php

class View {
	public $data = array();

	public function __construct() 
	{
		
	}
	private function loadView($name)
	{
		if (file_exists(VIEW_PATH . $name . '.php'))
		{
			require_once(VIEW_PATH . $name . '.php');
		}
		else throw new MyException('View file not found: '.$name,1);
		return $this;
	}
	private function clean($text)
	{
		return trim(strtolower(str_replace(' ' ,'-',$text)));
	}
	public function assign($field,$value)
	{
		//Creating property object dinamically
		$this->{$field} = $value;
		return $this;
	}
	public function makeLink($first,$option)
	{
		return WEB_PATH.implode('/',array($first,$this->clean($option))).'/';
	}
	public function display($name, $noInclude = false, $admin = false)
	{
		echo $this->render($name, $noInclude, $admin);
		return $this;
	}
	public function render($name, $noInclude = false, $admin = false)
	{
		ob_start();
		if ($noInclude)
		{
			$this->loadView($name);
		}
		else if($admin)
		{
			$this->loadView('admin/header-admin')->loadView('admin/'.$name)->loadView('admin/footer-admin');
		}
		else 
		{
			$this->loadView('header')->loadView($name)->loadView('footer');
		}
		$view = ob_get_contents();
		ob_end_clean();
		return $view;
	}
}
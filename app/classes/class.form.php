<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Form 
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MATCH = 'match';
    const RULE_UNIQUE = 'unique';
    
	public $action,
			$method,
			$name,
			$enctype = ['application/x-www-form-urlencoded','multipart/form-data','text/plain'],
			$onsubmit,
			$formStart;

	public function __construct() 
	{
		
    }
	function openForm($name = 'form', $method = 'POST', $action = '#', $enctype = 0, $onsubmit = ''){
        $this->action = $action;
        $this->method = $method;
        $this->name = $name;
        $this->enctype = $this->enctype[$enctype];
        $this->onsubmit = $onsubmit;
        
        $this->formStart = "<form name='".$this->name."' action='".$this->action."' method='".$this->method."' enctype='".$this->enctype."' onsubmit='".$this->onsubmit."'>";
        return $this->formStart;
    }
 
}
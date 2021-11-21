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
	function makeForm($form){
        //create form start
        $this->formStart = $this->makeStart($form[0]);
    //   foreach ($form as  $value) {
    //         foreach ($value as $key) {
    //             echo $key;
    //         }
    //   }
        // $this->formStart = "<form name='".$this->name."' action='".$this->action."' method='".$this->method."' enctype='".$this->enctype."' onsubmit='".$this->onsubmit."'>";
        // return $this->formStart;
    }

    public function makeStart($formStart)
    {
        // print_r($formStart);
        foreach ($formStart as $key => $value) {
            echo $value;
        }
    }
 
}
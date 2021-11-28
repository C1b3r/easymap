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
			$formStart,
            $formFields,
            $completeForm;

	public function __construct() 
	{
		
    }
	function makeForm($form){
        //create form start
        $this->formStart = $this->makeStart($form[0]);
        $this->formFields = $this->addField($form[1]);
        $this->completeForm = $this->formStart.$this->formFields."</form>";
    //   foreach ($form as  $value) {
    //         foreach ($value as $key) {
    //             echo $key;
    //         }
    //   }
        // $this->formStart = "<form name='".$this->name."' action='".$this->action."' method='".$this->method."' enctype='".$this->enctype."' onsubmit='".$this->onsubmit."'>";
        return $this->completeForm;
    }

    public function makeStart($formStart)
    {
        //We make form start with whitespace to concat all attributes of form tag. Dinamically we have defined in the model admin
        $form = '<form ';
        foreach ($formStart as $key => $value) {

           if($key == "enctype"){ $value = $this->enctype[$value];}

           $form.= $key."='$value' ";
        }
       return $form.= '>';
    }

    public function addField($fields)
    {
        $completefields = '';
        foreach ($fields as $key => $properties) {
            $label = '';
            $container = '';
            $field = '';

            $id = (isset($properties['id'])) ? $properties['id'] : '' ;
            $name = (isset($properties['name'])) ? $properties['name'] : '' ;
            $type = (isset($properties['type'])) ? $properties['type'] : '' ;
            $class = (isset($properties['class'])) ? $properties['class'] : '' ;
            $placeholder = (isset($properties['placeholder'])) ? $properties['placeholder'] : '' ;
            $attributes = (isset($properties['attributes'])) ? $properties['attributes'] : '' ;
           
             if (is_array($properties)){

                if(isset($properties['container'])){
                    $wrap = $this->addWrap($properties['container']);
                }
                if(isset($properties['label'])){
                    $label = $this->addLabel($properties['label']);
                }
                if(isset($properties['validations'])){
                    
                }
                if($type == "textarea"){
                    $field = "<textarea name='$name' class='$class' id='$id' $attributes >$placeholder</textarea>";
                }else{
                    $field = "<input type='$type' name='$name' class='$class' id='$id' $attributes placeholder='$placeholder'>";
                }

                if(!empty($label)){
                    $field = str_replace("inputlabelposition", $field, $label);
                }
                if(!empty($wrap)){
                    $field = str_replace("inputdivposition", $field, $wrap);
                }

                $completefields.= $field;
                // foreach ($properties as $propertykey => $propertyValue) {
                //         if($propertykey== "label" && is_array($propertyValue)){ 
                //             $label = $this->addLabel($propertyValue);
                //             continue;
                //         }
                //         if($propertykey== "container" && is_array($propertyValue)){ 
                //             $wrap = $this->addWrap($propertyValue);
                //             continue;
                //         }
                //         if($propertykey== "validations" && is_array($propertyValue)){ 
                //             // $wrap = $this->addWrap($propertyValue);
                //             continue;
                //         }
                        


                //         if(!empty($label)){
                //             $field = str_replace("inputlabelposition", $field, $label);
                //         }
                //         echo $propertyValue;
                // }
             }
        }
        return $completefields;
    }

    public static function makeSecureForm()
    {

    }

    public function addLabel($label)
    {
        $text = (isset($label['text']))? $label['text'] : '' ; 
        $class = (isset($label['class']))? $label['class'] : '' ; 
        $position = (isset($label['position']))? $label['position'] : '' ;
        
        switch ($position) {
            case 'start':
                return "<label class='".$class."'>".$text."</label>"." inputlabelposition";
                break;
            case 'end':
                return "inputlabelposition "."<label class='".$class."'>".$text."</label>";
                break;
            case 'wrap':
                return "<label class='".$class."'>".$text." inputlabelposition"."</label>";
                break;
            
            default:
            return "inputlabelposition "."<label class='".$class."'>".$text."</label>";
                break;
        }
   
    }

    public function addWrap($wrap)
    {
        $class = (isset($wrap['class']))? $wrap['class'] : '' ;
        $attributes = (isset($wrap['attributes']))? $wrap['attributes'] : '' ;
        $type = (isset($wrap['type']))? $wrap['type'] : '' ;
        return "<$type class='$class' $attributes>"."inputdivposition"."</$type>";
    }
 
}
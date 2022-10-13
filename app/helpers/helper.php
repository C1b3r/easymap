<?php
//  namespace app\classes;

use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;

defined('ROOT_PATH') or exit('Direct access forbidden');

class Helper 
{
	public static $redirect;
	public static $urlGeneration;

	public static function removeAccents($str) {

		$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή','\'');
		$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η','');
		return str_replace($a, $b, $str);
	  }

	  
	  public static function getMail()
	  {
		  $mail = new Mail();
		  return $mail; 
	  }

	  public static function setFlash($type,$name,$flash_message)
	  {
		//Si hay alguna sesión ya creada con ese nombre, la borra
		if (isset($_SESSION['flash'][$name])) {
			unset($_SESSION['flash'][$name]);
		}
		//Instancio un array para luego hacer push
		$_SESSION['flash'][$name] = [];
		if(is_array($flash_message)){
		foreach ($flash_message as $key => $value) {
			if(is_array($value)){
				foreach ($value as $message) {
					//Para que lo haga como un array de posición y no se sustituya en cada iteración
					array_push($_SESSION['flash'][$name], sprintf('<div class="alert alert-%s alert-dismissible fade show" role="alert">%s   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
					$type,
					$message));
				}
			}else{
				array_push($_SESSION['flash'][$name], sprintf('<div class="alert alert-%s alert-dismissible fade show" role="alert">%s   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
				$type,
				$value));
			}
		
		}	
	}else{
		array_push($_SESSION['flash'][$name], sprintf('<div class="alert alert-%s alert-dismissible fade show" role="alert">%s   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>',
		$type,
		$flash_message));
	}
			
	  }

	  public static function getFlash()
	  {
		  if(isset($_SESSION['flash']) && !empty($_SESSION['flash'])){
			foreach($_SESSION['flash'] as $name => $message)
			{
				if(is_array($message)){
					foreach ($message as $value) {
						echo $value;
					}
				}else{
					echo $message;
				}
				
				unset($_SESSION['flash'][$name]);
			}
		  }
	  }

	  public static function redirect($routes,$request)
	  {
		self::$urlGeneration = new UrlGenerator($routes, $request);
		// Create the redirect instance
		self::$redirect = new Redirector(self::$urlGeneration);
	  }

	  public static function breadcrumb($separator = ' &raquo; ', $home = 'Home')
	  {
		$subfolders = explode('/',CURRENT_DIRECTORY);
		// This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
		$path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), function($var) use($subfolders){
			if(!in_array($var, $subfolders)){
				return $var;
			}
		});

		// This will build our "base URL"
		$base = (in_array(ADMIN_FOLDER,$path)) ? COMPLETE_WEB_PATH_ADMIN :COMPLETE_WEB_PATH;

		// Initialize a temporary array with our breadcrumbs.
		$breadcrumbs = Array('<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
		<li class="breadcrumb-item "><a class="text__link" href="'.$base.'">'.$home.'</a></li>');

		// Find out the index for the last value in our path array
		$keys = array_keys($path);
		$last = end($keys);
		// Build the rest of the breadcrumbs
		foreach ($path as $current => $crumb) {
			// Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
			$title = ucwords(str_replace(Array('.php', '_','-'), Array('', ' ',' '), $crumb));
			//Quit admin string from url and edit and next number id page
			if($crumb === ADMIN_FOLDER || strtolower($crumb) === 'edit' || is_numeric($crumb)){
				continue;
			}
			// If we are not on the last index, then display an <a> tag
			if ($current != $last){

				$breadcrumbs[] = '<li class="breadcrumb-item ">
				<a class="text__link" href="'.$base.$crumb.'">'.$title.'</a>
				</li>'; 
			} 
			// Just display the current page
			else{
				$breadcrumbs[] =  '<li class="breadcrumb-item active body__text" aria-current="page">'.$title.'</li>';
			}
 		}		
		$breadcrumbs[] = '</ol>
		</nav>';

		// Build our temporary array (pieces of bread) into one big string :)
		return implode($separator, $breadcrumbs);
	  }

}
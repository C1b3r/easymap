<?php
defined('ROOT_PATH') or exit('Direct access forbidden');
class MyException extends Exception
{
	const THROW_SIMPLE = 0;
	const THROW_MEDIUM = 1;
	const THROW_HARD = 2;
	
    public function __construct($msg = '',$function = '', $code = 0)
    {
		parent::__construct($msg, (int) $code);
		switch($code)
		{
			case self::THROW_MEDIUM:
				//log error
				$archivo = fopen(LOG_PATH.$function.'.txt', "a+");
				fwrite($archivo, "[".date("d-m-Y H:i:s")."] ".$msg.PHP_EOL);
				fclose($archivo);

			break;
			case self::THROW_HARD:
				$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'direct';
				$request_uri = $_SERVER['REQUEST_URI'];
				$message = $_SERVER['REMOTE_ADDR'] . "referrer=".$referrer . "\n request_uri=" . $request_uri."\n" . $msg;
				$subject = 'Fatal error on: ' . WEB_PATH;
				Helper::getMail()->setMessage($message)->setSubject($subject)->send();
			break;			
		}
    }

}

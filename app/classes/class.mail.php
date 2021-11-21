<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Mail
{

	private $headers,$message,$subject,$address;
	
	public function __construct()
	{
		$this->address = 'mail admin';
	}
	public function setHeaders($from = 'mapfletadmin@'.WEB_PATH)
	{
		$email_headers  = 'MIME-Version: 1.0' . "\r\n";
		$email_headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$email_headers .= 'From: '. $from . "\r\n";
		$email_headers .= 'Reply-To:'. $from ." \r\n";
		// $email_headers .= 'X-Mailer: PHP/'.phpversion();	
		$this->headers = $email_headers;
		return $this;
	}
	public function setMessage($message)
	{
		$this->message = $message;
		return $this;
	}
	public function setSubject($subject)
	{
		$this->subject = $subject;
		return $this;
	}
	public function setAddress($address)
	{
		$this->address = $address;
		return $this;
	}
	public function send()
	{
		@mail($this->address,$this->subject,$this->message,$this->headers);	
	}

}

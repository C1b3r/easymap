<?php
// namespace app\classes;
defined('ROOT_PATH') or exit('Direct access forbidden');

class Mail
{

	private $headers,$message,$subject,$address;
	
	public function __construct($email)
	{
		$this->address = $email;
		$this->setHeaders();
	}
	public function setHeaders()
	{
		$email_headers  = 'MIME-Version: 1.0' . "\r\n";
		$email_headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		// $email_headers .= 'X-Mailer: PHP/'.phpversion();	
		$this->headers = $email_headers;
		// return $this;
	}
	public function setFrom($from = 'easymapadmin@'.CURRENT_DOMAIN)
	{
		$this->headers .='From: '. $from . "\r\n";
		return $this;
	}
	public function setReply($from = 'easymapadmin@'.CURRENT_DOMAIN)
	{
		$this->headers .= 'Reply-To:'. $from ." \r\n";
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
/*

   $to = 'recipients@email-address.com';
   $subject = 'Hello from XAMPP!';
   $message = 'This is a Mailhog test';
   $headers = "From: your@email-address.com\r\n";

   if (mail($to, $subject, $message, $headers)) {
      echo "SUCCESS";
   } else {
      echo "ERROR";
} */
}

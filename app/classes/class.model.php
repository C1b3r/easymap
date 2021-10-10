<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Model {
	private $db;
	protected function secure($value)
	{
		return trim(strip_tags($value));
	}
	public function __construct() {
		 $this->db = new Connection();
	}

	public function __destruct()
	{
		$this->db->closeConnection();
	}

}
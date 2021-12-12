<?php
defined('ROOT_PATH') or exit('Direct access forbidden');

class Model extends Connection
{
	protected $db;
	public $form = [];
	public $result,$count,$limit;

	public function __construct() 
	{
		parent::__construct();
    }

	protected function secure($value)
	{
		return trim(strip_tags($value));
	}
	public function prepare($sql) 
	{
		return $this->conexion->prepare($sql);//inutil hasta que herede de conection
	}

	protected function runQuery($sql,$dataToBind = array())
	{
		$sql = trim($sql);
        
        try {
			$stmt = $this->conexion->prepare($sql);
			if(!empty($dataToBind)){
				/* In this case, bindparam in foreach with value need to pass by reference, by default allways 
				use variable by value, $value it's by value, because bindParam needs &$value) https://www.php.net/manual/fr/pdostatement.bindparam.php#98145 */
				foreach ($dataToBind as $key => &$value) {
					$type_param = (is_numeric($value))? PDO::PARAM_INT: PDO::PARAM_STR;
					//not need ":". in the $key
					$stmt->bindParam($key, $value,$type_param); 
				}

			}
            $stmt->execute();
			// echo $stmt->debugDumpParams();
            return $stmt;

        } catch (PDOException $e) {
			new MyException("Query error: ". $e->getMessage()." on function ".__FUNCTION__,basename($e->getFile()),1);
        }
	}
	public function select($table, $data, $extrawhere = '', $fields = "*")
	// public function select($table, $where="", $bind = array(), $fields = "*")
	{
		if(is_array($data) && $fields != "*"){
			$fields = implode(', ',array_keys($data));
		}
		//extract name of column database (defined in controller validation param)
		$sql = "SELECT " . $fields . " FROM ".DB_PREFIX.$table;
		/* If i defined in data an array of column name and where, if i only wants all result, dont do it anything */
		$sql.= ($this->is_assoc($data)) ? $this->createWhere($data) : '';
		//If i defined data array and wants specific extra where
		$sql.= (!empty($extrawhere) || !isset($extrawhere))? " AND ".$extrawhere : '';
		$sql.= (!empty($this->limit))? " LIMIT ".$this->limit : '';

        $this->result = $this->runQuery($sql, $data);
		$this->count = $this->result->rowCount();
		return $this;

	}
	/* To create where clause to bind later */
	public function createWhere($data)
	{
		$values = implode(' AND ',$data);
		$sql = " WHERE ";
		$where = array();
		foreach ($data as $key => $value) {
			$where[] .= $key.' =:'.$key." ";
		}
		//To make where and correctly
		$sql .= implode('AND ', $where);
		// $sql .= ";";
		return $sql;
	}

	public function selectOneRowBy($table,$by,$param)
	{
		$sql = "SELECT * FROM ".DB_PREFIX.$table." WHERE ".$by."='".$param."'";
	}

	public function checkOneRow($table,$by,$param)
	{
		try {
 			$stmt =$this->conexion->prepare("SELECT * FROM ".DB_PREFIX.$table." WHERE ".$by."= :param");
			$stmt->bindParam("param", $param,PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchColumn();
		
		} catch (PDOException $e) {
			new MyException("Connection failed: ". $e->getMessage()." on function ".__FUNCTION__,basename($e->getFile()),1);
		}
	
	}

	/* We need to know if it is an associative array to know if it comes from a post or is a simple query*/
	public function is_assoc($array)
	{
		if(is_array($array) && isset($array)){
			if(array_values($array) !== $array){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	
	}

	public function mapFormColumn($fields,$data)
	{
		$columnArray = array();
		foreach($fields as $key => $val) {
			//Extract all rules of current form field
			$fieldRules = explode("|", $val);
			$encrypt = false;
			foreach ($fieldRules as  $value) {
				//Extract rules and validation
				$ruleValue = Validation::_getRuleSuffix($value);
				$rule = Validation::_removeRuleSuffix($value);
				if($rule == "encrypt"){
					$encrypt = true;
				}
				if($rule == "column"){
					//store in array with columname and value from form
					$columnArray[$ruleValue] = ($encrypt)? md5($data[$key]) : $data[$key] ;
				}

			}
		}
		return $columnArray;
	}

	public function fetchArray($loop = true)
	{
		if($loop){
			 $data = array();
			while ($row = $this->result->fetch(PDO::FETCH_ASSOC) ) {
				$data[] = $row;
			}
			return $data;
		}
		return $this->result->fetch(PDO::FETCH_ASSOC);
	}
	public function fetchObj($loop = false)
	{
		if($loop){
			$data = array();
		   while ($row = $this->result->fetch(PDO::FETCH_OBJ) ) {
			   $data[] = $row;
		   }
		   return $data;
	   }
		return $this->result->fetch(PDO::FETCH_OBJ);
	}
	public function fetchAllArray()
	{
		return $this->result->fetchAll(PDO::FETCH_ASSOC);
	}
	public function fetchAllObj($loop = false)
	{
		return $this->result->fetchAll(PDO::FETCH_OBJ);
	}
	public function __destruct()
	{
		$this->closeConnection();
		// echo "conexion cerrada";
	}

}
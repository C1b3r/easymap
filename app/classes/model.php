<?php
namespace app\classes;
defined('ROOT_PATH') or exit('Direct access forbidden');
use Illuminate\Database\Eloquent\Model as Eloquent;
use app\classes\Validation;

class Model extends Eloquent
{
	protected $db;
	public $form = [];
	public $result,
			$count,
			$limit = 25 ,
			$totalrow,
			$total_pages,
			$conectar,
			$validator;

	public function __construct() 
	{
		// parent::__construct();
		$this->conectar = new Connection;
		// Boot::$app->capsule = $this->conectar;
    }

	public function validation()
	{
		$this->validator = new Validation($this->conectar);
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
					$type_param = (is_numeric($value))? \PDO::PARAM_INT: \PDO::PARAM_STR;
					//not need ":". in the $key
					$stmt->bindParam($key, $value,$type_param); 
				}

			}
            $stmt->execute();
			// $this->totalrow = $stmt->fetchColumn(); this prevents me from fetching later as array and object, i will use rowCount or make flag
			// $this->totalrow = $stmt->rowCount();
			// echo $stmt->debugDumpParams();
            return $stmt;

        } catch (\PDOException $e) {
			new MyException("Query error: ". $e->getMessage()." on function ".__FUNCTION__,basename($e->getFile()),1);
        }
	}
	// public function select($table, $data, $extrawhere = '', $fields = "*")
	// {
	// 	if(is_array($data) && $fields != "*"){
	// 		$fields = implode(', ',array_keys($data));
	// 	}
	// 	//extract name of column database (defined in controller validation param)
	// 	$sql = "SELECT " . $fields . " FROM ".DB_PREFIX.$table;
	// 	/* If i defined in data an array of column name and where, if i only wants all result, dont do it anything */
	// 	$sql.= ($this->is_assoc($data)) ? $this->createWhere($data) : '';
	// 	//If i defined data array and wants specific extra where
	// 	$sql.= (!empty($extrawhere) || !isset($extrawhere))? " AND ".$extrawhere : '';
	// 	$sql.= (!empty($this->limit) && isset($this->limit))? " LIMIT ".$this->limit : '';

    //     $this->result = $this->runQuery($sql, $data);
	// 	$this->count = $this->result->rowCount();
	// 	return $this;

	// }

	public function selectRB($table)
	{

	}
	/**
	 * *We use this funcion only for make pagination select. 
	 * *On the first time, make select to get the total rows
	 * *Secondly, retrieves the information with limit clause
	 * @param table We need the name of the table
	 * @param limit To give the limit of the query
	 * @param page to set the current page 
	 * @param where to give extra specific information 
	 * @param fields to select all field or only specific column, is a string separated by comma
	 */
	public function selectPagination($table,$page = 1, $where = '',$fields = '*')
	{
		$sqlTotal = "SELECT COUNT(*) FROM ".DB_PREFIX.$table;
		$whereclause = ($this->is_assoc($where)) ? $this->createWhere($where) : '';
		$sqlTotal.= $whereclause;
		$this->result = $this->runQuery($sqlTotal);
		$this->totalrow = $this->result->fetchColumn();
		// $this->total_pages = ceil($this->totalrow/$limit);
		$this->total_pages = $this->totalrow;

		$sql =  "SELECT $fields FROM ".DB_PREFIX.$table;
		$sql.= $whereclause;
		$sql.= " LIMIT " . ( ( $page - 1 ) * $this->limit ) . ", $this->limit";
		$this->result = $this->runQuery($sql);

		//To get the data in array
		$results = $this->fetchArray(true);
		//Creation of no name class and assing properties to pass more easy
		$result         = new \stdClass();
		$result->page   = $page;
		$result->limit  = $this->limit;
		$result->total  = $this->total_pages;
		$result->data   = $results;
		return $result;

	}
	/**
	 * *we use this function to bind later
	 *   @param data We need to specify in an array column value array("column database name" => "value") 
	 *   
	 */ 
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
			$stmt->bindParam("param", $param,\PDO::PARAM_STR);
			$stmt->execute();
			return $stmt->fetchColumn();
		
		} catch (\PDOException $e) {
			new MyException("Connection failed: ". $e->getMessage()." on function ".__FUNCTION__,basename($e->getFile()),1);
		}
	
	}

	/**
	 * *Need to know if it is an associative array to know if it comes from a post or is a simple query. Using array values to extract values from array and check if its equal to array, if its simple array, its equal and no associative.
	 * @param array give associative array (or not) to check it 
	 */ 
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
			while ($row = $this->result->fetch(\PDO::FETCH_ASSOC) ) {
				$data[] = $row;
			}
			return $data;
		}
		return $this->result->fetch(\PDO::FETCH_ASSOC);
	}
	public function fetchObj($loop = false)
	{
		if($loop){
			$data = array();
		   while ($row = $this->result->fetch(\PDO::FETCH_OBJ) ) {
			   $data[] = $row;
		   }
		   return $data;
	   }
		return $this->result->fetch(\PDO::FETCH_OBJ);
	}
	public function fetchAllArray()
	{
		return $this->result->fetchAll(\PDO::FETCH_ASSOC);
	}
	public function fetchAllObj($loop = false)
	{
		return $this->result->fetchAll(\PDO::FETCH_OBJ);
	}
	public function __destruct()
	{
		// $this->closeConnection();
		$this->conectar->conexion->disconnect('default');
		// echo "conexion cerrada";
	}

}
<?php

require_once dirname(__FILE__) . "/../configs/database.php";

abstract Class BaseModel extends Connector {
	protected $table = null;

	protected $operators = array(
		'=', '<', '>', '<=', '>=', '<>', '!=',
		'like', 'not like', 'between', 'ilike',
		'&', '|', '^', '<<', '>>',
		'rlike', 'regexp', 'not regexp',
	);

	protected function invalidOperatorAndValue($operator, $value) {
	$isOperator = in_array($operator, $this->operators);
	return ($isOperator && $operator != '=' && is_null($value));
	}

	public function all() {
		$result = $this->connect()->prepare("SELECT * FROM {$this->table}");
		$result->execute();
		return $result->fetchAll();
	}

	public function where($column, $operator = null, $value = null) {
		if (func_num_args() == 2)
		{
			list($value, $operator) = array($operator, '=');
		}
		elseif ($this->invalidOperatorAndValue($operator, $value))
		{
			throw new Exception("Value must be provided.", 1);
		}

		$result = $this->connect()->prepare("SELECT * FROM {$this->table} WHERE $column $operator :value");
		$result->bindParam(':value', $value);
		$result->execute();
		return $result->fetchAll();
	}

}

// DON'T TOUCH THIS PHP TAG!!
/**
if(basename($_SERVER["PHP_SELF"]) == "index.php"){
die("You aren't supposed to be here. Please Check your link and try again.");}
**/
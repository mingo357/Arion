<?php
require_once dirname(__FILE__) . "/baseModel.php";

Class Requests extends BaseModel {
	protected $table = "requests";

	public function addRequest($array) {
		if(
			!isset($array["address"]) ||
			!isset($array["item"]) ||
			!isset($array["store"]) ||
			!isset($array["price"]) ||
			!isset($array["time"]) 
		) {
			return false;
		}

		$result = $this->connect()->prepare("INSERT INTO {$this->table} (address, item, `desc`, store, price, time, userid, `status`) VALUES (:address, :item, :desc, :store, :price, :time, 0, 0)");
		$result->bindParam(':address', $array["address"]);
		$result->bindParam(':item', $array["item"]);
		$result->bindParam(':store', $array["store"]);
		$result->bindParam(':price', $array["address"]);
		$result->bindParam(':desc', $array["desc"]);
		$result->bindParam(':time', $array["time"]);
		if ($result->execute()) {
			return true;
		} else {
			return false;
		}
	}

}
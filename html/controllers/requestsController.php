<?php

require_once dirname(__FILE__) . "/../models/requestsModel.php";
$Requests = new Requests();

if (isset($_GET["add"])) {
	$address = $_POST["address"];
	$item = $_POST["item"];
	$store = $_POST["store"];
	$price = $_POST["price"];
	$time = time();
	$desc = $_POST["desc"];
	if (!preg_match("/[a-zA-Z0-9\s_.-]{5,}/", $address)) {
		die("The address is not valid.");
	} elseif (!is_numeric($price)) {
		die("The price is not valid.");
	} else {
		if(
			$Requests->addRequest(array(
				'address' => $address,
				'item' => $item,
				'store' => $store,
				'price' => $price,
				'time' => $time,
				'desc' => $desc,
			))
		)
		{
			echo 'Request successfully added!';
		} else {
			die("An error occured.");
		}
	}
}
<?php

require_once dirname(__FILE__) . "/../models/requestsModel.php";
header('Content-Type: application/javascript; charset=utf-8');

$Requests = new Requests();

if (isset($_GET["add"])) {
	$address = $_POST["address"];
	$item = $_POST["item"];
	$store = $_POST["store"];
	$price = $_POST["price"];
	$time = time();
	$desc = $_POST["desc"];
	if (!preg_match("/[a-zA-Z0-9\s_.-]{5,}/", $address)) {
		die("alert(\"Please enter a valid address.\");");
	} elseif (!is_numeric($price)) {
		die("alert(\"Please enter a valid price.\");");
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
			echo 'alert("Request successfully sent!");';
		} else {
			die("alert(\"An error occured.\");");
		}
	}
}
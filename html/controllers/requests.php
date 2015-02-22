<?php
ini_set('xdebug.var_display_max_depth', 16);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 1024);
header('Content-Type: text/xml; charset=utf-8');

require_once "../models/requestsModel.php";
require_once "../configs/vars.php";
require_once "../libs/XML.php";


$origins = "";
if (isset($_GET['origins'])) {
	$origins = $_GET['origins'];
} else {
  die("Argument is missing");
}
$origins = urlencode($origins);
$requests = new Requests();
$results = $requests->all();
array_walk_recursive($results, function(&$item, $key){
    if(!mb_detect_encoding($item, 'utf-8', true)){
            $item = utf8_encode($item);
    }
});
$destinations = array();
$coords = array();
foreach ($results as $result) {
  $tmp = urlencode($result["address"]);
	array_push($destinations, $tmp);

  $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=$tmp&key=" . GOOGLE_API_KEY);
  $parse = json_decode($json);
  $location = $parse->results[0]->geometry->location;
  array_push($coords, array(
    'lat' => $location->lat,
    'lng' => $location->lng,
  ));

}
$destinations = implode('|', $destinations);
$json = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origins&destinations=$destinations&mode=bicycling&language=en&key=" . GOOGLE_API_KEY);
$parse = json_decode($json);
$elements = $parse->rows[0]->elements;

$return = array();
$count = count($results);
if ($count >= 5) {
  $count = 5;
}
for ($i=0; $i < $count ; $i++) { 
  array_push($return, array(
    'address' => $results[$i]["address"],
    'lat' => $coords[$i]["lat"],
    'lng' => $coords[$i]["lng"],
    'item' => $results[$i]["item"],
    'desc' => $results[$i]["desc"],
    'store' => $results[$i]["store"],
    'price' => $results[$i]["price"],
    'distance' => $elements[$i]->distance->value,
  ));
}
usort($return, function($a, $b) {
    return $a['distance'] - $b['distance'];
});
echo XMLSerializer::generateValidXmlFromArray($return);


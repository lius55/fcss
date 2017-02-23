<?php
header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');

include_once '../config.php';

$lat = $_POST["lat"];
$lng = $_POST["lng"];

$lat_dis = 0.054945;
$lng_dis = 0.045045;

$min_lat = $lat - $lat_dis;
$max_lat = $lat + $lat_dis;
$min_lng = $lng - $lng_dis;
$max_lng = $lng + $lng_dis;

$response = new stdClass();

$stmt =$dbh->prepare("select * from trn_location where lat between :min_lat and :max_lat "
		. " and lng between :min_lng and :max_lng");
$stmt->bindParam(":min_lat", $min_lat);
$stmt->bindParam(":max_lat", $max_lat);
$stmt->bindParam(":min_lng", $min_lng);
$stmt->bindParam(":max_lng", $max_lng);

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
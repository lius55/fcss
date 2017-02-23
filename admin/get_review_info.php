<?php
header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');

include_once '../config.php';

$response = new stdClass();
session_start();

$location_id = $_POST["location_id"];
$version_id = $_POST["version_id"];

// 認証判定
if(isset($_SESSION["auth"]) && $_SESSION["auth"]) {

	$response->response_status = "ok";

	$stmt = 
		$dbh->prepare("select location_id,version_id,location_name,lat,lng,"
			. "address,postcode,contact_tel,business_time,profile,insert_date "
			. "from trn_location_his where location_id = :location_id and version_id = :version_id");

	$stmt->bindParam(":location_id", $location_id);
	$stmt->bindParam(":version_id", $version_id);
	$stmt->execute();
	//$result->location_info = new stdClass();
	$response->location_info = $stmt->fetch(PDO::FETCH_OBJ);
} else {
	$response->response_status = "invalid request";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
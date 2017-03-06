<?php
header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');

include_once 'config.php';

$location_id = $_POST["location_id"];
$version_id = $_POST["version_id"];

$response = new stdClass();

$stmt =$dbh->prepare("select location_id,location_name,address,version_id,lat,lng,contact_tel,business_time "
		." from trn_location where location_id = :location_id  and version_id = :version_id");

$stmt->bindParam(":location_id", $location_id);
$stmt->bindParam(":version_id", $version_id);

$stmt->execute();
$response->location_info = $stmt->fetch(PDO::FETCH_OBJ);

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
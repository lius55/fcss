<?php
header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');

include_once '../config.php';

$response = new stdClass();
session_start();

// 認証判定
if(isset($_SESSION["auth"]) && $_SESSION["auth"]) {
	$response->response_status = "ok";
	$response->location_list = array();
	$stmt = $dbh->prepare("select location_id,version_id,location_name,"
		. "address,insert_date "
		. "from trn_location_his where status = 'WAIT_REVIEW' order by insert_date desc limit 10");
	$stmt->execute();
	while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
		$response->location_list[] = $row;
	}
} else {
	$response->response_status = "invalid request";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
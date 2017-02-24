<?php 
header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');

include_once '../config.php';

$response = new stdClass();

$location_id = $_POST["location_id"];
$version_id = $_POST["version_id"];
$status = $_POST["status"];

try {

	// 履歴テーブル更新
	$dbh->prepare("update trn_location_his set status= :status "
		. "where location_id = :location_id and version_id = :version_id");
	$stmt->bindParam(":location_id", $location_id);
	$stmt->bindParam(":version_id", $version_id);
	$stmt->bindParam(":status", $status);
	$stmt->execute();

	// 更新成功の場合、trnテーブルにコピー
	if(($stmt->rowCount() > 0) && ($status == STATUS_REVIEW_OK)) {
		$stmt = 
			$dbh->prepare("INSERT INTO trn_location SELECT * FROM trn_location_his " 
				. "where location_id = :location_id and version_id = :version_id");

		$stmt->bindParam(":location_id", $location_id);
		$stmt->bindParam(":version_id", $version_id);

		$stmt->execute();
		$response->response_status = RESPONSE_OK;
	} else {
		$response->response_status = PROCESS_ERROR;
	}

} catch (PDOException $e) {
     $response->response_status = PROCESS_ERROR;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
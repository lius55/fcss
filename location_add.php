<?php
header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');

include_once 'config.php';
require_once 'PHPMailer/PHPMailerAutoload.php';

$response = new stdClass();

// パラメーター取得
$address = $_REQUEST["address"];
$location_name = $_REQUEST["location_name"];
$lat = $_REQUEST["lat"];
$lng = $_REQUEST["lng"];
$contact_tel = isset($_REQUEST["contact_tel"]) ? $_REQUEST["contact_tel"] : '';
$business_time = isset($_REQUEST["business_time"]) ? $_REQUEST["business_time"] : '';
$email = isset($_REQUEST["email"]) ? $_REQUEST["email"] : '';
$note = isset($_REQUEST["note"]) ? $_REQUEST["note"] : '';

try{

	$stmt = $dbh->prepare("INSERT INTO trn_location_his(version_id, location_name, lat, lng, "
 			. "address, status, category_id, contact_tel, business_time, contributor_email, "
 			. "note, insert_date, insert_user, update_date, update_user) "
 			. "VALUES (1, :location_name, :lat, :lng, :address, 'WAIT_REVIEW', 1, :contact_tel, " 
 			. ":business_time, :contributor_email, :note, CURRENT_TIMESTAMP, "
 			. "'contributor', CURRENT_TIMESTAMP, 'contributor')");

 	$stmt->bindParam(':location_name', $location_name);
 	$stmt->bindParam(':lat', $lat);
 	$stmt->bindParam(':lng', $lng);
 	$stmt->bindParam(':address', $address);
 	$stmt->bindParam(':contact_tel', $contact_tel);
 	$stmt->bindParam(':business_time', $business_time);
 	$stmt->bindParam(':contributor_email', $email);
 	$stmt->bindParam(':note', $note);

 	$stmt->execute();

 	if(strlen($email) > 0) {

 		$mail = new PHPMailer();
 		if(!send_mail(
 			$mail, 
 			"感谢您的分享", 
 			"感谢您的分享，我们会尽快进行审查，审查结束后会以邮件的形式通知您，请稍稍等候。", 
 			$email)) {
 			// メール送信
			$response->response_status = "process error:" . $mail->ErrorInfo;
		}
 	}

} catch (PDOException $e) {
     $response->response_status = PROCESS_ERROR;
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);

?>
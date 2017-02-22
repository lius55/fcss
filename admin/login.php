<?php
header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');

include_once '../config.php';

$username = $_POST["username"];
$password = $_POST["password"];

$stmt = 
	$dbh->prepare("select count(*) as num from mst_admin where username=:username and password=:password");

$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);
$stmt->execute();

$result = $stmt->fetch(PDO::FETCH_OBJ);

$response = new stdClass();
if($result->num > 0){
	session_start();
	$_SESSION["auth"] = true;
	$response->auth_code = "success";
} else {
	$response->auth_code = "failure";
}

// 検索結果返却
echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
<?php
header("Content-type: text/html; charset=utf-8");
header('Content-Type: application/json');

include_once '../config.php';

$response = new stdClass();
session_start();

// 認証判定
if(isset($_SESSION["auth"]) && $_SESSION["auth"]) {
	$response->response_status = "ok";
} else {
	$response->response_status = "invalid request";
}

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
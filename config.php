<?php

// DB接続設定
define('DB_HOST', 'localhost');
define('DB_NAME', 'location_schema');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');

// 文字化け対策
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET CHARACTER SET 'utf8'");

// PHPのエラーを表示するように設定
error_reporting(E_ALL & ~E_NOTICE);

$dbh = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD, $options);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

define('PROCESS_ERROR', 'process error');
define('RESPONSE_OK', 'ok');
define('INVALID_REQUEST', 'invalid request');
define('STATUS_REVIEW_OK', 'REVIEW_OK');
?>
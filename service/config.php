<?php
date_default_timezone_set("Asia/Bangkok");
header('Content-type: text/html; charset=utf-8');
require_once 'PDO.php';

$db_host = 'localhost';
$db_name = 'matchminton';
$db_user = 'root';
$db_pass = '';

$conn = new PDO("mysql:host=$db_host; dbname=$db_name", $db_user, $db_pass);
$conn->exec("SET CHARACTER SET utf8");

<?php
session_start();
header('Content-type: text/html; charset=utf-8');
defined("DB_HOST") ? null : define("DB_HOST", "localhost:3306");
defined("DB_USER") ? null : define("DB_USER", "root");
defined("DB_PASS") ? null : define("DB_PASS", "");
defined("DB_NAME") ? null : define("DB_NAME", "ro_shop");
$db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$db->query('SET character_set_client="utf8",character_set_connection="utf8",character_set_results="utf8";');
if(!$db) { die(mysqli_error($db)); }
require_once("functions.php");
?>
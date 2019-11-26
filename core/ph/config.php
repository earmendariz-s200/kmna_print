<?php
	session_start();
	error_reporting(1);

	$URL_PRINCIPAL = "http://3.86.229.197/carmona/";
	if($_SESSION["DIR_LOCAL"] == ""){ header("locaction: ".$URL_PRINCIPAL); }
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_ALL, "es_ES");
	$_SESSION["DIR_LOCAL"] = "/carmona";
	define("DB_HOST", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "status2oo");
	define("DB_NAME", "pimprenta");
	require_once("pdo/mysql.pdo.lib.php");
	$db = new Db();


	function guid(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = ""
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                ."";// "}"
        return $uuid;
	    }
	}


?>

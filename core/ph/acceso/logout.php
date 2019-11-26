<?php
	include "../config.php";
	session_start();
	$url = $URL_PRINCIPAL;
	session_destroy();
	header("location:".$url);
?>

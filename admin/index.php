<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
$page = ($_GET['page']) ? $_GET['page'] : $_POST['page'];

include_once "header.php";
if(!isset($_SESSION['timecardID'])) {
	include_once "login.php";
} else if(isset($_SESSION['timecardID'])) {
	switch($page) {
		default : {
			include_once "dashboard.php";
			break;
		}
		case "login" : {
			include_once "login.php";
			break;
		}
		case "logout" : {
			include_once 'logout.php';
			break;
		}
		case "dashboard" : {
			include_once 'dashboard.php';
			break;
		}
	}
	include_once "footer.php";
}
?>

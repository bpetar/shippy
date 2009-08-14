<?
	//include_once("../../classes/ftp.php");
	//include_once("../../classes/locale.php");
	//include_once("../../classes/template.php");
	
	$sectionid = $_GET["sectionid"];
	$act = $_GET["act"];
	$id =  $_GET["id"];
	$locale_id = $_GET["locale"];

	$name = $_POST["name"];
	$code = $_POST["code"];
	$password = $_POST["password"];
	$email = $_POST["email"];
	$type = $_POST["type"];
	$stores = $_POST["stores"];
	if ($stores == null) $stores = Array();

	
	include_once("../lib/mainvars.php");
	include_once("../lib/login.php");
?>
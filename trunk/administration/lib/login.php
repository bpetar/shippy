<?
session_start();
include_once("../../classes/oraclesql.php");
include_once("../../classes/admin.php");
if(isset($_SESSION['userSS'])){
  	$user = new admin;
  	$user = unserialize($_SESSION['userSS']);
}else{
	header("Location:../index.php");
}
?>
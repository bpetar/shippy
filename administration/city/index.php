<?
	session_start();

	include("../lib/mainvars.php");
	include("../lib/expl.php");
	include("../../classes/dbsql.php");
	include("../../classes/admin.php");
	include("../../classes/city.php");

	$act = $_GET["act"];
	$id =  $_GET["id"];
	$typeid =  $_GET["typeid"];

	include("../lib/header.php");
	include_once("code.php");
?>
	<div id="middWrapp">
		<div id="menudiv">
<?
	include_once("menu.php");
?>
		</div>
		<div id="contdiv">
<?
	include_once("content.php");
?>
		</div>
	</div>
<?
	include("../lib/footer.php");
?>
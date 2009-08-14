<?
	include("lib/mainvars.php");
	include("classes/dbsql.php");
	include("classes/admin.php");
	include("classes/city.php");
	include("classes/store.php");

	$act = $_GET["act"];
	$id =  $_GET["id"];
?>

	
<?
	include("header.php");
?>
	
	
	<div id="middWrapp" style="border: 1px solid;">

		<div id="menudiv" style="border: 1px solid red; color:#EEEEEE; background-color:#111111; width:160px; float:left;">
<?
	include_once("menu.php");
?>
		</div>
		<div id="contdiv" style="color:#EEEEEE; background-color:#111111;">
<?
	include_once("content.php");
?>
		</div>
	</div>
	

	<div id="foot" style="text-align:center; color:#EEEEEE; background-color:#111111;">
<?
	include("footer.php");
?>
	</div>
	
</body>
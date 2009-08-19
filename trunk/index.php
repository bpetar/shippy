<?
	include("lib/mainvars.php");
	include("classes/dbsql.php");
	include("classes/admin.php");
	include("classes/city.php");
	include("classes/store.php");
	include("classes/ptype.php");
	include("classes/product.php");

	$act = $_GET["act"];
	$storeid =  $_GET["storeid"];
?>


<?
	include("header.php");
?>
	
	
	<div id="middWrapp" style="border: 1px solid;">

		<div id="menudiv">
<?
	include_once("menu.php");
?>
		</div>
		<div id="contdiv">
<?
	if(!$act) {
		include_once("content.php");
	} else if($act=="show_cities") {
		include_once("content.php");
	} else if($act=="show_store") {
		include_once("content_store.php");
	}
?>
		</div>
	</div>
	

	<div id="foot" style="text-align:center; color:#EEEEEE; background-color:#111111;">
<?
	include("footer.php");
?>
	</div>
	
</body>
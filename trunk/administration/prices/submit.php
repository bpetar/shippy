<?
	include("../lib/mainvars.php");
	include("../lib/expl.php");
	include("../../classes/dbsql.php");
	include("../../classes/product.php");
	include("../../classes/admin.php");
	$username = $_GET["username"];
	$password = $_GET["password"];
	$productid = $_GET["productid"];
	$storeid = $_GET["storeid"];
	$price = $_GET["price"];
	
	$code = "1";
	$message = "nepoznata greska";

	$product = new product();
	$admin = new admin();
	$admin->name = $username;
	$admin->password = $password;
	$login = $admin->login();
	if(!$login)
	{
		$message = "Nepoznat administrator, proverite ime i lozinku.";
	}
	else
	{
		$allowed = $admin->isAllowed(6, $storeid);
		if(!$allowed)
		{
			$message = "Administrator ne moze da menja ovu prodavnicu.";
		}
		else
		{
			$message = $product->enterPrice($productid, $storeid, $price, $admin->id);
			if ($message == "Cena uspesno unesena")
			{
				$code = "0";
			}
		}
	}	
	
	if (isset($id))
		$prices = $product->getPricesByStore($id);
	echo($code."#".$message."#".$productid."#".$price."#".$storeid."#");
?>
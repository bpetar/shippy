<?
session_start();

include_once("../lib/mainvars.php");
include_once("../../classes/dbsql.php");
include_once("../../classes/admin.php");
include_once("../../classes/product.php");
include_once("../../classes/ptype.php");

/*$product = new product();
$ptype = new ptype();
$ptypes = $ptype->getAllTypes();
echo("<?xml version=\"1.0\"?>");
echo("<prices>");
foreach($ptypes as $type)
{
	echo("<type name=\"".htmlspecialchars($type['name'])."\">");
	$products = $product->getAllTypeProducts($type['id']);
	foreach($products as $item)
	{
		echo("<product id=\"".$item['id']."\" name=\"".htmlspecialchars($item['name'])."\">");
		echo("<prices>");
		$prices = $product->getPricesByProduct($item['id']);	
		foreach($prices as $price)
		{
			echo("<store id=\"".$price['id_store']."\" price=\"".$price['price']."\"/>");
		}
		echo("</prices>");
		echo("</product>");
	}
	echo("</type>");
}
echo("</prices>");*/
$fp = fopen ("../../cenovnik/products.xml", "w+");
$product = new product();
$ptype = new ptype();
$ptypes = $ptype->getAllTypes();
fwrite($fp, "<?xml version=\"1.0\"?>");
fwrite($fp, "<prices>");
foreach($ptypes as $type)
{
	fwrite($fp, "<type name=\"".htmlspecialchars($type['name'])."\">");
	$products = $product->getAllTypeProducts($type['id']);
	foreach($products as $item)
	{
		fwrite($fp, "<product id=\"".$item['id']."\" name=\"".htmlspecialchars($item['name'])."\">");
		fwrite($fp, "<prices>");
		$prices = $product->getPricesByProduct($item['id']);	
		foreach($prices as $price)
		{
			fwrite($fp, "<store id=\"".$price['id_store']."\" price=\"".$price['price']."\"/>");
		}
		fwrite($fp, "</prices>");
		fwrite($fp, "</product>\n");
	}
	fwrite($fp, "</type>\n");
}
fwrite($fp, "</prices>");
fclose($fp);
?>
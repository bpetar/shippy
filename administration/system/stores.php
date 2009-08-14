<?
session_start();

include_once("../lib/mainvars.php");
include_once("../../classes/dbsql.php");
include_once("../../classes/admin.php");
include_once("../../classes/store.php");
include_once("../../classes/city.php");

/*$store = new store();
$city = new city();
$cities = $city->getAllCities();
echo("<?xml version=\"1.0\"?>");
echo("<stores>");
foreach($cities as $cityItem)
{
	echo("<city name=\"".htmlspecialchars($cityItem['name'])."\" abbr=\"".htmlspecialchars($cityItem['name'])."\">\n");
	$stores = $store->getAllStoresByCity($cityItem['id']);	
	foreach($stores as $item){
		echo("<store>");
		echo("<id>".$item['id']."</id>");
		echo("<name>".htmlspecialchars($item['name'])."</name>");
		echo("<address>".htmlspecialchars($item['contact'])."</address>");
		echo("<rate>rate</rate>");
		echo("<comments>comments</comments>");
		echo("</store>\n");
	}
	echo("</city>\n");
}
echo("</stores>");*/

$fp = fopen ("../../cenovnik/stores.xml", "w+");
$store = new store();
$city = new city();
$cities = $city->getAllCities();
fwrite($fp, "<?xml version=\"1.0\"?>");
fwrite($fp, "<stores>");
foreach($cities as $cityItem)
{
	fwrite($fp, "<city name=\"".htmlspecialchars($cityItem['name'])."\" abbr=\"".htmlspecialchars($cityItem['name'])."\">\n");
	$stores = $store->getAllStoresByCity($cityItem['id']);	
	foreach($stores as $item)
	{
		fwrite($fp, "<store>");
		fwrite($fp, "<id>".$item['id']."</id>");
		fwrite($fp, "<name>".htmlspecialchars($item['name'])."</name>");
		fwrite($fp, "<address>".htmlspecialchars($item['contact'])."</address>");
		fwrite($fp, "<rate>rate</rate>");
		fwrite($fp, "<comments>comments</comments>");
		fwrite($fp, "</store>\n");
	}
	fwrite($fp, "</city>\n");
}
fwrite($fp, "</stores>");
fclose($fp);
?>
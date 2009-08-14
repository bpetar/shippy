<?
	$spaceImg = "<img src='../img/spacer.gif' width='1' height='1' border='0' />";
	$selArray = array("redTxt");
	if(!isset($id)){
		$id = "0";
	}
	
	$mshop = new store();
	echo ("<a href='index.php' class='leftLinkHead'>Unesi novu prodavnicu</a><br><br>");
	
	$mshops = $mshop->getAllStores();
	for ($i = 0; $i<sizeof($mshops);$i++){
		echo ("&nbsp;&nbsp;<a href='index.php?act=select&id=".$mshops[$i]["id"]
		."' class='leftLink'>".$mshops[$i]["name"].", ".$mshops[$i]["city_name"]."</a><br>");
	}
?>
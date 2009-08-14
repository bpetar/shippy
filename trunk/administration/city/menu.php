<?
	$spaceImg = "<img src='../img/spacer.gif' width='1' height='1' border='0' />";
	$selArray = array("redTxt");
	if(!isset($id)){
		$id = "0";
	}
	
	$mcity = new city();
	echo ("<a href='index.php' class='leftLinkHead'>Unesi novi grad</a><br><br>");
	
	$mcities = $mcity->getAllCities();
	for ($i = 0; $i<sizeof($mcities);$i++){
		echo ("&nbsp;&nbsp;<a href='index.php?act=select&id=".$mcities[$i]["id"]."' class='leftLink'>".$mcities[$i]["name"]."</a><br>");
	}

?>
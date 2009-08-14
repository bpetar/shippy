<?
	$spaceImg = "<img src='../img/spacer.gif' width='1' height='1' border='0' />";
	$selArray = array("redTxt");
	if(!isset($id)){
		$id = "0";
	}
	
	$mptype = new ptype();
	echo ("<a href='index.php' class='leftLinkHead'>Unesi novi tip proizvoda</a><br><br>");
	
	$mptypes = $mptype->getAllTypes();
	for ($i = 0; $i<sizeof($mptypes);$i++){
		echo ("&nbsp;&nbsp;<a href='index.php?act=select&id=".$mptypes[$i]["id"]."' class='leftLink'>".$mptypes[$i]["name"]."</a><br>");
	}

?>
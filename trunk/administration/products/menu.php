<?
	$spaceImg = "<img src='../img/spacer.gif' width='1' height='1' border='0' />";
	$selArray = array("redTxt");
	if(!isset($id)){
		$id = "0";
	}
	
	$mprod = new product();
	$mptype = new ptype();
	echo ("<a href='index.php' class='leftLinkHead'>Unesi novi proizvod</a><br><br>");
	
	$mtypes = $mptype->getAllTypes();
	for ($i = 0; $i<sizeof($mtypes);$i++){
		echo ("<a href='index.php?typeid=".$mtypes[$i]["id"]."' class='leftLinkHead'>".$mtypes[$i]["name"]."</a><br>");
		if (isset($typeid) && $typeid == $mtypes[$i]["id"]){
			$mproducts = $mprod->getAllTypeProducts($mtypes[$i]["id"]);
			for ($j = 0; $j<sizeof($mproducts);$j++){
				echo ("&nbsp;&nbsp;&nbsp;<a href='index.php?act=select&typeid=".$mtypes[$i]["id"]."&id=".$mproducts[$j]["id"]."' class='leftLink'>".$mproducts[$j]["name"]."</a><br>");
			}
		}
	}
?>
<?
	$spaceImg = "<img src='../img/spacer.gif' width='1' height='1' border='0' />";
	$linkArray = array("leftLink", "leftLinkLite");
	$selArray = array("redTxt");
	if(!isset($id)){
		$id = "0";
	}
	if($user->type == $su){
  		$menu = new SystemMenu();
  		$menu->show($locale);
	}
?>
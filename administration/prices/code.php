<?
	$act = $_GET["act"];

	if(isset($_SESSION['userSS'])){
		$user=new admin;
		$user=unserialize($_SESSION['userSS']);
	}else{
		header("Location:../index.php");
	}

	$product = new product();
	echo("pera product\n");
	if (isset($id))
	{
		if ($user->isAllowed(6, $id))
		{
			$prices = $product->getPricesByStore($id);
			echo($id);
		}
		else
		{
			$error = true;
			$message = $user->message;	
		}		
	}
	switch($act){
		case "select":
			$act = "update";
			break;
		case "insert":
			break;
		case "update":
			break;
		default:
			$act = "insert";
	}
?>
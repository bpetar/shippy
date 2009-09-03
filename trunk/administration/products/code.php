<?
	$name = $_POST["name"];
	$image_small = $_POST["image_small"];
	$image_big = $_POST["image_big"];
	$ptype = $_POST["ptype"];
	$bar_code = $_POST["bar_code"];
	$typeid = $_GET["typeid"];

	$act = $_GET["act"];

	if(isset($_SESSION['userSS'])){
		$user=new admin;
		$user=unserialize($_SESSION['userSS']);
	}else{
		header("Location:../index.php");
	}

	$product = new product();
	if (isset($id))
		$product->getById($id);
	switch($act){
		case "select":
			$act = "update";
			break;
		case "insert":
			$product->set(null, $name, $image_small, $image_big, $ptype);
			$res = $product->insert();
			if ($res == -99)
				$message = "Proizvod sa tim imenom vec postoji. Odaberite drugo ime.";
			if($product->id == -1){
				$act = "insert";
				$error = 1;
			}else{
				$act = "select";
			}
			break;
		case "update":
			$product->set($id, $name, $image_small, $image_big, $ptype);
			$error = ($product->update() < 0);
			break;
		case "del":
			$result = $product->delete();
			$error = ($result < 0);
			if (!$error) {
				$product = new product();
				$act = "insert";
			} else {
				$act = "select";
			}
			break;
		default:
			$act = "insert";
	}
?>
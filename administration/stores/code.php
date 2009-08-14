<?
	$name = $_POST["name"];
	$image_small = $_POST["image_small"];
	$image_big = $_POST["image_big"];
	$city = $_POST["city"];
	$url = $_POST["url"];
	$contact = $_POST["contact"];

	$act = $_GET["act"];

	if(isset($_SESSION['userSS'])){
		$user=new admin;
		$user=unserialize($_SESSION['userSS']);
	}else{
		header("Location:../index.php");
	}

	$store = new store();
	if (isset($id))
		$store->getById($id);
	switch($act){
		case "select":
			$act = "update";
			break;
		case "insert":
			$store->set(null, $name, $city, $url, $contact, $image_small, $image_big);
			$res = $store->insert();
			if ($res == -99)
				$message = "Prodavnica sa tim imenom vec postoji. Odaberite drugo ime.";
			if($store->id == -1){
				$act = "insert";
				$error = 1;
			}else{
				$act = "select";
			}
			break;
		case "update":
			$store->set($id, $name, $city, $url, $contact, $image_small, $image_big);
			$error = ($store->update() < 0);
			break;
		case "del":
			$result = $store->delete();
			$error = ($result < 0);
			if (!$error) {
				$store = new store();
				$act = "insert";
			} else {
				if ($result == -2)
				{
					$message = "Postoje cene za ovu prodavnicu. Obrisite prvo njih.";
				}
				$act = "select";
			}
			break;
		default:
			$act = "insert";
	}
?>